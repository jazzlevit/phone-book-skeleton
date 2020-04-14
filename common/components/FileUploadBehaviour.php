<?php
/**
 * Created by PhpStorm.
 * User: Lesha
 * Date: 20.05.15
 * Time: 2:25
 */

namespace common\components;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class FileUploadBehaviour extends Behavior
{
    public $inputName = 'img';
    public $folderPath = 'uploads/img';
    public $extension = '.jpg';
    public $nameAsId = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    /**
     * Save uploaded file
     * @param $event
     * @return bool
     * @throws yii\base\Exception
     */
    public function afterSave($event)
    {
        if (!FileHelper::createDirectory($this->getStoragePath())) {
            Yii::$app->session->setFlash('errt', 'Storage doesn\'t exist or not writable!');
            return false;
        }

        if (!$this->saveFileInStorage()) {
            Yii::$app->session->setFlash('errt', 'File can\'t be saved on disk!');
            return false;
        }
    }

    /**
     * Delete exist file
     * @param $event
     */
    public function afterDelete($event)
    {
        @unlink($this->getFilePath());
    }

    /**
     * $inputName load url
     * @param $event
     */
    public function afterFind($event)
    {
        $this->owner->{$this->inputName} = $this->getFileUrl();
    }

    public function getFileName()
    {
        return $this->owner->id;
    }

    public function getFileUrl()
    {
        if ($this->isExistFile()) {
            $time = isset($this->owner->updated_at) ? $this->owner->updated_at : time();

            if($this->nameAsId) {
                return $this->getStorageUrl(). $this->getFileName() . $this->extension . '?v=' . $time;
            } else {
                return $this->getStorageUrl(). $this->inputName . '-' . $this->getFileName() . $this->extension . '?v=' . $time;
            }
        }
    }

    protected function isExistFile()
    {
        return file_exists($this->getFilePath());
    }

    protected function getFilePath()
    {
        if($this->nameAsId) {
            return $this->getStoragePath() . $this->getFileName() . $this->extension;
        } else {
            return $this->getStoragePath() . $this->inputName . '-' . $this->getFileName() . $this->extension;
        }
    }

    protected function getStoragePath()
    {
        return Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $this->folderPath . DIRECTORY_SEPARATOR;
    }

    protected function getStorageUrl()
    {
        return Yii::getAlias('@base/') . $this->folderPath . '/';
    }

    protected function saveFileInStorage()
    {
        if ($this->owner->{$this->inputName} = UploadedFile::getInstance($this->owner, $this->inputName)) {
            $this->owner->{$this->inputName}->saveAs($this->getFilePath());
        }

    }

}