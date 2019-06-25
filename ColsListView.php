<?php
/**
 * User: execut
 * Date: 14.09.15
 * Time: 17:19
 */

namespace execut\colsListView;


use yii\helpers\Html;

class ColsListView extends \yii\widgets\ListView
{
    public $textAttribute = 'name';
    public $itemTemplate = '{item}';
    public $valAttribute = 'id';
    protected $currentCount = 0;
    protected $isStaticColumns = false;
    public function renderItems() {
        return parent::renderItems();
    }

    public function renderItemValue($row, $key, $index) {
        if (is_callable($itemTemplate = $this->itemTemplate)) {
            return $itemTemplate($row, $key, $index);
        } else {
            return $row->{$this->textAttribute};
        }
    }

    public function renderItem($row, $key, $index) {
        $dataProvider = $this->dataProvider;
        $textAttribute = $this->textAttribute;
        $valAttribute = $this->valAttribute;
        $content = $this->renderItemValue($row, $key, $index);
        if ($this->isStaticColumns) {
            $result = '';
            $partSize = ceil(count($dataProvider->models) / 3);
            if ($index == 0) {
                $result .= '<div class="col-sm-4">';
                $this->currentCount++;
            } else if ($this->currentCount == $partSize) {
                $result .= '</div><div class="col-sm-4">';
                $this->currentCount = 1;
            } else {
                $this->currentCount++;
            }


            $result .= Html::tag('div', $content, [
                'class' => 'item',
                'val' => $row->$valAttribute,
                'text' => $row->$textAttribute,
            ]);

            if ($row === $dataProvider->models[count($dataProvider->models) - 1]) {
                $result .= '</div>';
            }
        } else {

            $result = '<div class="col-sm-4 col-xs-6">' . Html::tag('div', $content, [
                    'class' => 'item',
                    'val' => $row->$valAttribute,
                    'text' => $row->$textAttribute,
                ]) . '</div>';
        }

        return $result;
    }
}