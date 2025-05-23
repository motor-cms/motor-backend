<?php

namespace Motor\Backend\VueInternationalizationGenerator;

use App;
use DirectoryIterator;
use Exception;
use SplFileInfo;

/**
 * Class Generator
 */
class Generator
{
    private $config;

    private $availableLocales = [];

    private $filesToCreate = [];

    public const VUEX_I18N = 'vuex-i18n';

    public const VUE_I18N = 'vue-i18n';

    /**
     * The constructor
     *
     * @param  array  $config
     */
    public function __construct($config = [])
    {
        if (! isset($config['i18nLib'])) {
            $config['i18nLib'] = self::VUE_I18N;
        }
        $this->config = $config;
    }

    /**
     * @param  string  $path
     * @param  bool  $umd
     * @param  bool  $withVendor
     * @return string
     *
     * @throws Exception
     */
    public function generateFromPath($path, $umd = null, $withVendor = false)
    {
        if (! is_dir($path)) {
            throw new Exception('Directory not found: '.$path);
        }

        $locales = [];
        $files = [];
        $dir = new DirectoryIterator($path);
        $jsBody = '';
        foreach ($dir as $fileinfo) {
            if (! $fileinfo->isDot()) {
                if (! $withVendor && in_array($fileinfo->getFilename(), ['vendor'])) {
                    continue;
                }

                $files[] = $fileinfo->getRealPath();
            }
        }
        asort($files);

        foreach ($files as $fileName) {
            $fileinfo = new SplFileInfo($fileName);

            $noExt = $this->removeExtension($fileinfo->getFilename());

            if ($fileinfo->isDir()) {
                $local = $this->allocateLocaleArray($fileinfo->getRealPath());
            } else {
                $local = $this->allocateLocaleJSON($fileinfo->getRealPath());
                if ($local === null) {
                    continue;
                }
            }

            if (isset($locales[$noExt])) {
                $locales[$noExt] = array_merge($local, $locales[$noExt]);
            } else {
                $locales[$noExt] = $local;
            }
        }

        // loop through all namespaces and get data from translation files
        $translator = app('translator');

        foreach ($translator->getLoader()
            ->namespaces() as $namespace => $directory) {
            $fileinfo = new SplFileInfo($directory);

            if (! $fileinfo->isDir()) {
                continue;
            }

            // get all files
            $dir = new DirectoryIterator($directory);
            $jsBody = '';
            $files = [];
            foreach ($dir as $fileinfo) {
                if (! $fileinfo->isDot()) {
                    $files[] = $fileinfo->getRealPath();
                }
            }

            foreach ($files as $fileName) {
                $fileinfo = new SplFileInfo($fileName);

                $noExt = $this->removeExtension($fileinfo->getFilename());

                if ($fileinfo->isDir()) {
                    $local = $this->allocateLocaleArray($fileinfo->getRealPath());
                } else {
                    $local = $this->allocateLocaleJSON($fileinfo->getRealPath());
                    if ($local === null) {
                        continue;
                    }
                }

                $locales[$noExt][$namespace] = $local;
            }
        }

        $locales = $this->adjustVendor($locales);

        $jsonLocales = json_encode($locales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).PHP_EOL;

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Could not generate JSON, error code '.json_last_error());
        }

        if (! $umd) {
            $jsBody = $this->getES6Module($jsonLocales);
        } else {
            $jsBody = $this->getUMDModule($jsonLocales);
        }

        return $jsBody;
    }

    /**
     * @param  string  $path
     * @param  bool  $umd
     * @return string
     *
     * @throws Exception
     */
    public function generateMultiple($path, $umd = null)
    {
        if (! is_dir($path)) {
            throw new Exception('Directory not found: '.$path);
        }
        $jsPath = base_path().$this->config['jsPath'];
        $locales = [];
        $fileToCreate = '';
        $createdFiles = '';
        $dir = new DirectoryIterator($path);
        $jsBody = '';
        foreach ($dir as $fileinfo) {
            if (! $fileinfo->isDot() && ! in_array($fileinfo->getFilename(), ['vendor'])) {
                $noExt = $this->removeExtension($fileinfo->getFilename());
                if (! in_array($noExt, $this->availableLocales)) {
                    App::setLocale($noExt);
                    $this->availableLocales[] = $noExt;
                }
                if ($fileinfo->isDir()) {
                    $local = $this->allocateLocaleArray($fileinfo->getRealPath());
                } else {
                    $local = $this->allocateLocaleJSON($fileinfo->getRealPath());
                    if ($local === null) {
                        continue;
                    }
                }

                if (isset($locales[$noExt])) {
                    $locales[$noExt] = array_merge($local, $locales[$noExt]);
                } else {
                    $locales[$noExt] = $local;
                }
            }
        }
        foreach ($this->filesToCreate as $fileName => $data) {
            $fileToCreate = $jsPath.$fileName.'.js';
            $createdFiles .= $fileToCreate.PHP_EOL;
            $jsonLocales = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).PHP_EOL;
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Could not generate JSON, error code '.json_last_error());
            }
            if (! $umd) {
                $jsBody = $this->getES6Module($jsonLocales);
            } else {
                $jsBody = $this->getUMDModule($jsonLocales);
            }

            if (! is_dir(dirname($fileToCreate))) {
                mkdir(dirname($fileToCreate), 0777, true);
            }

            file_put_contents($fileToCreate, $jsBody);
        }

        return $createdFiles;
    }

    /**
     * @return array|null
     *
     * @throws Exception
     */
    private function allocateLocaleJSON($path)
    {
        // Ignore non *.json files (ex.: .gitignore, vim swap files etc.)
        if (pathinfo($path, PATHINFO_EXTENSION) !== 'json') {
            return null;
        }
        $tmp = (array) json_decode(file_get_contents($path), true);
        if (gettype($tmp) !== 'array') {
            throw new Exception('Unexpected data while processing '.$path);
        }

        return $this->adjustArray($tmp);
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    private function allocateLocaleArray($path)
    {
        $data = [];
        $dir = new DirectoryIterator($path);
        $lastLocale = last($this->availableLocales);
        foreach ($dir as $fileinfo) {
            // Do not mess with dotfiles at all.
            if ($fileinfo->isDot()) {
                continue;
            }

            if ($fileinfo->isDir()) {
                // Recursivley iterate through subdirs, until everything is allocated.

                $data[$fileinfo->getFilename()] = $this->allocateLocaleArray($path.'/'.$fileinfo->getFilename());
            } else {
                $noExt = $this->removeExtension($fileinfo->getFilename());
                $fileName = $path.'/'.$fileinfo->getFilename();

                // Ignore non *.php files (ex.: .gitignore, vim swap files etc.)
                if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'php') {
                    continue;
                }

                if (isset($this->config['langFiles']) && ! empty($this->config['langFiles']) && ! in_array($noExt, $this->config['langFiles'])) {
                    continue;
                }

                $tmp = include $fileName;

                if (gettype($tmp) !== 'array') {
                    throw new Exception('Unexpected data while processing '.$fileName);

                    continue;
                }
                if ($lastLocale !== false) {
                    $root = realpath(base_path().$this->config['langPath'].'/'.$lastLocale);
                    $filePath = $this->removeExtension(str_replace('\\', '_', ltrim(str_replace($root, '', realpath($fileName)), '\\')));
                    $this->filesToCreate[$filePath][$lastLocale] = $this->adjustArray($tmp);
                }

                $data[$noExt] = $this->adjustArray($tmp);
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    private function adjustArray(array $arr)
    {
        $res = [];
        foreach ($arr as $key => $val) {
            $key = $this->adjustString($key);

            if (is_string($val)) {
                $res[$key] = $this->adjustString($val);
            } else {
                $res[$key] = $this->adjustArray($val);
            }
        }

        return $res;
    }

    /**
     * Adjus vendor index placement.
     *
     * @param  array  $locales
     * @return array
     */
    private function adjustVendor($locales)
    {
        if (isset($locales['vendor'])) {
            foreach ($locales['vendor'] as $vendor => $data) {
                foreach ($data as $key => $group) {
                    foreach ($group as $locale => $lang) {
                        $locales[$key]['vendor'][$vendor][$locale] = $lang;
                    }
                }
            }

            unset($locales['vendor']);
        }

        return $locales;
    }

    /**
     * Turn Laravel style ":link" into vue-i18n style "{link}" or vuex-i18n style ":::".
     *
     * @return string|string[]|null
     */
    private function adjustString($string)
    {
        if (! is_string($string)) {
            return $string;
        }

        if ($this->config['i18nLib'] === self::VUEX_I18N) {
            $searchPipePattern = '/(\s)*(\|)(\s)*/';
            $threeColons = ' ::: ';
            $string = preg_replace($searchPipePattern, $threeColons, $string);
        }

        return preg_replace_callback('/(?<!mailto|tel):\w+/', static function ($matches) {
            return '{'.mb_substr($matches[0], 1).'}';
        }, $string);
    }

    /**
     * Returns filename, with extension stripped
     *
     * @param  string  $filename
     * @return string
     */
    private function removeExtension($filename)
    {
        $pos = mb_strrpos($filename, '.');
        if ($pos === false) {
            return $filename;
        }

        return mb_substr($filename, 0, $pos);
    }

    /**
     * Returns an UMD style module
     *
     * @param  string  $body
     * @return string
     */
    private function getUMDModule($body)
    {
        return <<<HEREDOC
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
        typeof define === 'function' && define.amd ? define(factory) :
            (global.vuei18nLocales = factory());
}(this, (function () { 'use strict';
    return {$body}
})));
HEREDOC;
    }

    /**
     * Returns an ES6 style module
     *
     * @param  string  $body
     * @return string
     */
    private function getES6Module($body)
    {
        return "export default {$body}";
    }
}
