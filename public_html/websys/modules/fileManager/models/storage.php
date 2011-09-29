<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/fileManager/models/storage.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: storage.php 3665 2009-09-02 00:53:17Z striker $
 */

/**
 * storage: класс для работы c данными
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2
 */
class storage extends entity
{
    protected $name = 'fileManager';

    public function rename($oldname, $newname)
    {
        $newname = $this->getPath() . $this->explode($newname);

        $dir = dirname($newname);
        $dir = DIRECTORY_SEPARATOR == '\\' ? str_replace('/', DIRECTORY_SEPARATOR, $dir) : $dir;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return rename($oldname, $newname);
    }

    public function moveUploadedFile($oldname, $newname)
    {
        $newname = $this->getPath() . $this->explode($newname);

        $dir = dirname($newname);
        $dir = DIRECTORY_SEPARATOR == '\\' ? str_replace('/', DIRECTORY_SEPARATOR, $dir) : $dir;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return move_uploaded_file($oldname, $newname);
    }

    public function saveImageSource($source, $newname)
    {
        $newname = $this->getPath() . $this->explode($newname);

        $dir = dirname($newname);
        $dir = DIRECTORY_SEPARATOR == '\\' ? str_replace('/', DIRECTORY_SEPARATOR, $dir) : $dir;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($newname, $source);
        return true;
    }

    public function delete($file)
    {
        if ($file instanceof file) {
            $name = $file->getRealname();
        } else {
            $name = $file;
        }

        if (file_exists($filename = $this->getPath() . $this->explode($name))) {
            return unlink($filename);
        }
    }

    public function is_file($name)
    {
        return is_file($this->getPath() . $name);
    }

    public function explode($name)
    {
        return $name[0] . '/' . $name[1] . '/' . $name[2] . '/' . $name[3] . '/' . substr($name, 4);
    }

    public function getLinkToFile($file)
    {
        if ($file instanceof file) {
            $file = $file->getRealname();
        }
        return $this->getPath() . $this->explode($file);
    }

    public function getDownloadLink(file $file)
    {
        return $this->getWebPath() . $this->explode($file->getRealname());
    }
}

?>