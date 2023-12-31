<?php

namespace app\components;

//namespace bsource\gridview;//in vendor folder

use \Yii;
use Closure;
use yii\i18n\Formatter;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\widgets\BaseListView;
use yii\base\Model;
use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Settings;
use \PHPExcel_Style_Fill;
use \PHPExcel_Writer_IWriter;
use \PHPExcel_Worksheet;

class ExcelGrid extends \yii\grid\GridView {

    public $columns_array;
    public $properties;
    public $filename = 'excel';
    public $extension = 'xlsx';
    public $is_pass = false;
    private $_provider;
    private $_visibleColumns;
    private $_beginRow = 1;
    private $_endRow;
    private $_endCol;
    private $_objPHPExcel;
    private $_objPHPExcelSheet;
    private $_objPHPExcelWriter;

    public function init() {
        parent::init();
    }

    public function run() {
        //$this->test();
        $this->init_provider();
        $this->init_excel_sheet();
        $this->initPHPExcelWriter('Excel2007');
        $this->generateHeader();
        $row = $this->generateBody();
        $writer = $this->_objPHPExcelWriter;
        $this->setHttpHeaders();
        $writer->save('php://output');
        Yii::$app->end();
        //$writer->save('test.xlsx');
        parent::run();
    }

    public function init_provider() {
        $this->_provider = clone($this->dataProvider);
    }

    public function init_excel_sheet() {
        $this->_objPHPExcel = new PHPExcel();

        $creator = '';
        $title = '';
        $subject = '';
        $description = 'Excel Grid Generated By BSOURCECODE extension';
        $category = '';
        $keywords = '';
        $manager = '';
        $company = 'BSOURCECODE';
        $created = date("Y-m-d H:i:s");
        $lastModifiedBy = '';
        extract($this->properties);
        if ($this->is_pass) {
            $this->_objPHPExcel->getSecurity()->setLockWindows(true);
            $this->_objPHPExcel->getSecurity()->setLockStructure(true);
            $this->_objPHPExcel->getSecurity()->setRevisionsPassword('bdsrongbay');
        }
        $this->_objPHPExcel->getProperties()
                ->setCreator($creator)
                ->setTitle($title)
                ->setSubject($subject)
                ->setDescription($description)
                ->setCategory($category)
                ->setKeywords($keywords)
                ->setManager($manager)
                ->setCompany($company)
                ->setCreated($created)
                ->setLastModifiedBy($lastModifiedBy);
        $this->_objPHPExcelSheet = $this->_objPHPExcel->getActiveSheet();
        if ($this->is_pass) {
            $this->_objPHPExcelSheet->getProtection()->setSheet(true);
            $this->_objPHPExcelSheet->getProtection()->setSort(true);
            $this->_objPHPExcelSheet->getProtection()->setInsertRows(true);
            $this->_objPHPExcelSheet->getProtection()->setFormatCells(true);
            $this->_objPHPExcelSheet->getProtection()->setPassword('bdsrongbay');
        }
    }

    public function initPHPExcelWriter($writer) {
        $this->_objPHPExcelWriter = PHPExcel_IOFactory::createWriter(
                        $this->_objPHPExcel, $writer
        );
    }

    public function generateHeader() {
        $this->setVisibleColumns();
        $sheet = $this->_objPHPExcelSheet;
        $colFirst = self::columnName(1);

        $this->_endCol = 0;
        foreach ($this->_visibleColumns as $column) {
            $this->_endCol++;
            $head = ($column instanceof \yii\grid\DataColumn) ? $this->getColumnHeader($column) : $column->header;
            $cell = $sheet->setCellValue(self::columnName($this->_endCol) . $this->_beginRow, $head, true);
        }
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->freezePane($colFirst . ($this->_beginRow + 1));
    }

    public function generateBody() {
        $columns = $this->_visibleColumns;
        $models = array_values($this->_provider->getModels());
        if (count($columns) == 0) {
            $cell = $this->_objPHPExcelSheet->setCellValue('A1', $this->emptyText, true);
            $model = reset($models);
            return 0;
        }
        $keys = $this->_provider->getKeys();
        $this->_endRow = 0;
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            $this->generateRow($model, $key, $index);
            $this->_endRow++;
        }

        // Set autofilter on
        $this->_objPHPExcelSheet->setAutoFilter(
                self::columnName(1) .
                $this->_beginRow .
                ":" .
                self::columnName($this->_endCol) .
                $this->_endRow
        );
        return ($this->_endRow > 0) ? count($models) : 0;
    }

    public function generateRow($model, $key, $index) {
        $cells = [];
        /* @var $column Column */
        $this->_endCol = 0;
        foreach ($this->_visibleColumns as $column) {
            if ($column instanceof \yii\grid\SerialColumn || $column instanceof \yii\grid\ActionColumn) {
                continue;
            } else {
                $format = $column->format;
                $value = ($column->content === null) ?
                        $this->formatter->format($column->getDataCellValue($model, $key, $index), $format) :
                        call_user_func($column->content, $model, $key, $index, $column);
            }
            if (empty($value) && !empty($column->attribute) && $column->attribute !== null) {
                $value = ArrayHelper::getValue($model, $column->attribute, '');
            }
            $this->_endCol++;
            $cell = $this->_objPHPExcelSheet->setCellValue(self::columnName($this->_endCol) . ($index + $this->_beginRow + 1), strip_tags($value), true);
        }
    }

    protected function setVisibleColumns() {
        $cols = [];
        foreach ($this->columns as $key => $column) {
            if ($column instanceof \yii\grid\SerialColumn || $column instanceof \yii\grid\ActionColumn) {
                continue;
            }
            $cols[] = $column;
        }
        $this->_visibleColumns = $cols;
    }

    public function getColumnHeader($col) {
        if (isset($this->columns_array[$col->attribute]))
            return $this->columns_array[$col->attribute];
        /* @var $model yii\base\Model */
        if ($col->header !== null || ($col->label === null && $col->attribute === null)) {
            return trim($col->header) !== '' ? $col->header : $col->grid->emptyCell;
        }
        $provider = $this->dataProvider;
        if ($col->label === null) {
            if ($provider instanceof ActiveDataProvider && $provider->query instanceof ActiveQueryInterface) {
                $model = new $provider->query->modelClass;
                $label = $model->getAttributeLabel($col->attribute);
            } else {
                $models = $provider->getModels();
                if (($model = reset($models)) instanceof Model) {
                    $label = $model->getAttributeLabel($col->attribute);
                } else {
                    $label = $col->attribute;
                }
            }
        } else {
            $label = $col->label;
        }
        return $label;
    }

    public static function columnName($index) {
        $i = $index - 1;
        if ($i >= 0 && $i < 26) {
            return chr(ord('A') + $i);
        }
        if ($i > 25) {
            return (self::columnName($i / 26)) . (self::columnName($i % 26 + 1));
        }
        return 'A';
    }

    protected function setHttpHeaders() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Cache-Control', 'no-cache');
        $headers->add('Expires', '0');
        $headers->add('Pragma', 'no-cache');
        $headers->add('Content-Type', 'application/vnd.ms-excel');
        $headers->add('Content-Disposition', "attachment; filename={$this->filename}.{$this->extension}");
    }

}
