<?php
namespace app\components;

use app\components\FileUpload;
use app\models\SeoPage;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;


class CController extends Controller
{

    public function generator_title_desSeo($title = '', $des = '', $keywords = '')
    {
        $view = $this->getView();
        if ($title) {
            $view->title = trim($title);
        }
        if ($des) {
            $this->registerMetaTag(['name' => 'description', 'content' => $des]);
        }
        if ($keywords) {
            $this->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
        }
    }

    public function beforeAction($event)
    {

        $this->layout = '@app/themes/basic/layouts/column0.php';
//        $is_mobile = Yii::$app->getRequest()->getQueryParam('is_mobile', '');
//        $detect = new Mobile_Detect();
//        if ($detect->isOnlyMobile() || $is_mobile === 'true') {
//            $this->layout = '@app/themes/mobile/layouts/column0.php';
//            Yii::$app->view->theme->pathMap = ['@app/views' => '@app/themes/mobile'];
//        }
        $route = Yii::$app->controller->getRoute();

        $seopage = SeoPage::getData($route);
        if ($seopage) {
            $title = $seopage['page_title'];
            $des = $seopage['page_description'];
            $keywords = $seopage['page_keywords'];
            $this->generator_title_desSeo($title, $des, $keywords);
            $socialTitle = trim($seopage['face_title']) ? trim($seopage['face_title']) : $seopage['page_title'];
            $socialDesc = trim($seopage['face_description']) ? trim($seopage['face_description']) : $seopage['face_description'];
            $socialImage = trim($seopage['face_image']) ? FileUpload::originalfile(trim($seopage['face_image'])) : '';
            if ($socialTitle) {
                $this->registerMetaTag(['property' => 'og:title', 'itemprop' => "headline", 'content' => $socialTitle]);
            }
            if ($socialDesc) {
                $this->registerMetaTag(['property' => 'og:description', 'itemprop' => "headline", 'content' => $socialDesc]);
            }
            if ($socialImage) {
                $this->registerMetaTag(['property' => 'og:image', 'itemprop' => "thumbnailUrl", 'content' => $socialImage]);
            }
        }

        return parent::beforeAction($event);
    }

    public function registerMetaTag($info = ['name', 'content'])
    {
        if (!empty($info)) {
            $view = Yii::$app->getView();
            $view->metaTags[] = "<meta" . Html::renderTagAttributes($info) . ' />';
        }
    }

    public function registerLinkTag($options = [])
    {
        if (!empty($options)) {
            $view = Yii::$app->getView();
            $view->linkTags[] = Html::tag('link', '', $options);
        }
    }


}
