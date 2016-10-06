<?php

    namespace backend\models;

    use yii\alexposseda\fileManager\FileManager;
    use yii\alexposseda\fileManager\models\FileManagerModel;
    use yii\imagine\Image;

    class OfferGallery extends FileManagerModel{
        public function uploadFile($directory){
            $fileName = uniqid(time(), true);
            $thumbName = 'thumb_'.$fileName;
            $this->savePath = $directory.DIRECTORY_SEPARATOR.$fileName.'.'.$this->file->extension;
            $this->file->saveAs(FileManager::getInstance()->getStoragePath().$this->savePath);
            Image::thumbnail(FileManager::getInstance()->getStoragePath().$this->savePath, 400, 400)
                 ->save(FileManager::getInstance()->getStoragePath().$directory.DIRECTORY_SEPARATOR.$thumbName.'.'.$this->file->extension, ['quality' => 80]);

            return $this;
        }
    }