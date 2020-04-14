<?php
/**
 * Created by PhpStorm.
 * User: Lesha
 * Date: 19.06.15
 * Time: 1:18
 */
namespace common\helpers;

use Yii;

class FileUploadHelper
{

    public static $temporaryFolder = 'temporary_files';

    /**
     * Detects max size of file cab be uploaded to server
     *
     * Based on php.ini parameters "upload_max_filesize", "post_max_size" &
     * "memory_limit". Valid for single file upload form. May be used
     * as MAX_FILE_SIZE hidden input or to inform user about max allowed file size.
     *
     * @return int	Max file size in bytes
     */
    public static function detectMaxUploadFileSize()
    {
        /**
         * Converts shorthands like "2M" or "512K" to bytes
         *
         * @param $size
         * @return mixed
         */
        $normalize = function($size) {
            if (preg_match('/^([\d\.]+)([KMG])$/i', $size, $match)) {
                $pos = array_search($match[2], array("K", "M", "G"));
                if ($pos !== false) {
                    $size = $match[1] * pow(1024, $pos + 1);
                }
            }
            return $size;
        };
        $max_upload = $normalize(ini_get('upload_max_filesize'));
        $max_post = $normalize(ini_get('post_max_size'));
        $memory_limit = $normalize(ini_get('memory_limit'));
        $maxFileSize = min($max_upload, $max_post, $memory_limit);
        return $maxFileSize;
    }


    public static function getStoragePath($folderName)
    {
        return Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR;
    }

    public static function getStorageUrl($folderName)
    {
        return Yii::getAlias('@base/') . $folderName . '/';
    }
}

