<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/fileManager/models/file.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: file.php 3665 2009-09-02 00:53:17Z striker $
 */

/**
 * file: класс для работы c данными
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2
 */
class file extends entity
{
    protected $extra = false;

    public function getFullPath()
    {
        return $this->getFolder()->getTreePath() . '/' . rawurlencode($this->getName());
    }

    public function getRealFullPath()
    {
        return $this->getStorage()->getLinkToFile($this);
    }

    public function getDownloadLink()
    {
        if ($this->getDirectLink()) {
            return $this->getStorage()->getDownloadLink($this);
        }

        $url = new url('withAnyParam');
        $url->setModule('fileManager');
        $url->add('name', $this->getFullPath());
        return $url->get();
    }
/*
    public function getUploadPath()
    {
        $toolkit = systemToolkit::getInstance();
        $config = $toolkit->getConfig('fileManager', $this->section);
        return $config->get('upload_path');
    } */

    public function getMd5()
    {
        if (is_file($this->getRealFullPath())) {
            return md5_file($this->getRealFullPath());
        }
    }

    public function getExt()
    {
        return strtolower($this->__call('getExt', array()));
    }

    /**
     * Загрузка файла
     *
     * @param string $name (optional)Имя с которым будет отдан файл.
     * @return file
     */
    public function download(fileMapper $mapper, $name = null)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $range = $request->getServer('HTTP_RANGE');
        if (empty($range)) {
            $this->setDownloads($this->getDownloads() + 1);
            $mapper->save($this);
        }

        set_time_limit(0);
        $fileName = $this->getRealFullPath();
        if (!empty($fileName) && file_exists($fileName)) {
            $fileSize = filesize($fileName);

            $offset = 0;
            $size = $fileSize - 1;

            if (!empty($range)) {
                $range = trim($range);
                $bytes = substr($range, strpos($range, "=") + 1);
                if ($bytes) {
                    $pos = strpos($bytes, "-");
                    $offset = (int)substr($bytes, 0, $pos);
                    $size = (int)substr($bytes, $pos + 1);

                    $size = ($size < 1) ? $fileSize - 1 : $size;

                    if ($offset > $size) {
                        $offset = 0;
                        $size = $fileSize - 1;
                    }

                    if (php_sapi_name() == "cgi") {
                        header("Status: 206 Partial Content");
                    } else {
                        header("HTTP/1.0 206 Partial Content");
                    }
                }
            }

            $age = 86400 * 30 * 6;

            header("Pragma: public");
            header("Cache-Control: public, must-revalidate, max-age=" . $age);
            header("Content-Length: " . ($size - $offset + 1));
            header("Content-Range: bytes " . $offset . "-" . $size . "/" . $fileSize);
            header("Last-Modified: " . date('r', filemtime($fileName)));
            header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $age) . ' GMT');

            if (empty($name)) {
                $name = $this->getName();
            }

            $mimetypes = $mapper->getMimetypes();
            if (!$this->getRightHeader() || !isset($mimetypes[$this->getExt()])) {
                header("Content-Disposition: attachment;"); // filename=\"" . rawurlencode($name) . "\"");
                header("Content-Type: application/x-octetstream");
            } else {
                header("Content-Type: " . $mimetypes[$this->getExt()]);
            }

            $headers = $request->getHeaders();
            $changed = true;
            if (isset($headers['If-Modified-Since'])) {
                $modified_since = strtotime($headers['If-Modified-Since']);

                $time_match = false;
                if ($modified_since <= time() && is_int($modified_since) && $modified_since >= filemtime($fileName)) {
                    $changed = false;
                }
            }

            if (!$changed) {
                header("HTTP/1.1 304 Not Modified");
                exit;
            }

            header("Content-Transfer-Encoding: binary");
            header("Accept-Ranges: bytes");
            if (ob_get_level()) {
                ob_end_clean();
            }

            $fp = fopen($fileName, "rb");
            if ($offset) {
                fseek($fp, $offset);
            }

            session_write_close();

            while ($offset <= $size) {
                $bufferSize = 262144;
                if ($bufferSize + $offset > $size) {
                    $bufferSize = $size - $offset + 1;
                }
                $offset += $bufferSize;
                echo fread($fp, $bufferSize);
                if (ob_get_level()) {
                    flush();
                }
            }
            fclose($fp);
            exit();
        }

        throw new mzzIoException($fileName);
    }
}

?>