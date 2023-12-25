<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets\admin\menu;

use \Yii;
use yii\widgets\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

class AdminMenu extends Menu
{
    public $linkTemplateRoot = '<a href="{url}">{label}</a>';

    public $activateMap = [];
    
    public function run(){                
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $items = $this->normalizeItems($this->items, $hasActiveChild);
        if (!empty($items)) {
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'ul');
            echo Html::tag($tag, $this->renderItems($items,1), $options);
        }
    }
    
    protected function renderItems($items,$root=0)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));            
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }
            
            $isParent = !empty($item['items']);
            $menu = $this->renderItem($item,$isParent,$root);
            if ($isParent) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            if ($tag === false) {
                $lines[] = $menu;
            } else {
                $lines[] = Html::tag($tag, $menu, $options);
            }
        }

        return implode("\n", $lines);
    }
        
    protected function renderItem($item,$is_parent = false,$root=0)
    {
        if (isset($item['url'])) {
            if($root){
                $template = ArrayHelper::getValue($item, 'template', $this->linkTemplateRoot);
            }else{
                $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            }

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{icon}'=>(isset($item['classIcon']))?'<i class="'.$item['classIcon'].'"></i>':'',
                '{label}' => $item['label'],
                '{arrow}'=> ($is_parent)?'<b class="arrow icon-angle-down"></b>':'',
                '{classitem}'=> ($is_parent)?'dropdown-toggle':'',
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
            return strtr($template, [
                '{icon}'=>(isset($item['classIcon']))?'<i class="'.$item['classIcon'].'"></i>':'',
                '{label}' => $item['label'],
                '{arrow}'=> ($is_parent)?'<b class="arrow icon-angle-down"></b>':'',
            ]);
        }
    }
    
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {            
            if ((isset($item['visible']) && !$item['visible']) || !$this->isVisible($item)) {                
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }
    
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if(isset($this->activateMap[$this->route])){
                $routeCheck = $this->activateMap[$this->route];
            }else{
                $routeCheck = $this->route;
            }

            if (strpos($routeCheck, ltrim($route, '/'))!==0 ) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
    
    protected function isVisible($item)
    {        
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = '/'.Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }            
            $user = Yii::$app->getUser();
            //check current route
            if($user->can($route)){            
                return true;
            }
            
            //all route then root route is ok
            if($user->can($route.'/*')){            
                return true;
            }
            
            //check supper admin
            if ($user->can('/*')) {
                return true;
            }
            
            //check recursive route
            if(strrpos($route,'/') !== false){
                $route = substr($route, 0,  strrpos($route,'/'));                                    
                do {
                    if ($user->can($route.'/*')) {
                        return true;
                    }
                    $route = ($route)?substr($route, 0, strrpos($route,'/')):"";                                    
                } while ($route !== "");
            }
        }        

        return false;
    }
}
