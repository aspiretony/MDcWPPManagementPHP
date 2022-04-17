<?php
/**
 * AdiantiFileHashGeneratorService
 *
 * @version    1.0
 * @package    core
 * @author     Pablo Dall'Oglio
 * @author     Lucas Tomasi
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class AdiantiFileHashGeneratorService
{
    const FILE_HASHES = 'app/config/framework_hashes.php';

    const REMOVED  = 'R';
    const MODIFIED = 'M';
    const EQUAL    = 'E';

    private static $files = [];

    /**
     * Encode hash sha512 file
     */
    private static function generateHash($filePath)
    {
        return hash_file('sha512', $filePath);
    }

    /**
     * Scan dir encoding files
     *
     * @param $dir path for encode
     */
    private static function generateFromDir($dir)
    {
        $files = scandir($dir);
    
        foreach ($files as $key => $value)
        {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            
            if (!is_dir($path))
            {
                self::generateFromFile($path);
            }
            else if ($value != "." && $value != "..")
            {
                self::generateFromDir($path);
            }
        }
    }

    /**
     * Include file hash
     *
     * @param $path path of file
     */
    private static function generateFromFile($path)
    {
        self::$files[ str_replace(getcwd() . '/', '', $path) ] = self::generateHash($path);
    }

    /**
     * Generate hashes
     */
    public static function generate()
    {
        self::generateFromFile('composer.json');
        self::generateFromFile('engine.php');
        self::generateFromFile('index.php');
        self::generateFromFile('init.php');
        self::generateFromDir('lib/adianti');
        self::generateFromDir('app/lib');
        self::generateFromDir('app/templates');

        return self::$files;
    }

    /**
     * Generate file with hashes
     */
    public static function generateFile()
    {
        self::generate();

        $hashes = [];

        foreach(self::$files as $path => $hash)
        {
            $hashes[] = "'{$path}' => '{$hash}'";
        }

        $stringHashes = implode(",\n", $hashes);

        $hashes = "<?php return [\n{$stringHashes}\n];";

        file_put_contents(self::FILE_HASHES, $hashes);
    }

    /**
     * Compare default files with project files
     * 
     * @return $balance array with balance between files
     */
    public static function compare()
    {
        $defaultFiles = require self::FILE_HASHES;
        $projectFiles = self::generate();

        $balance = [];
        foreach ($defaultFiles as $file => $hash)
        {
            if(empty($projectFiles[$file]))
            {
                $balance[$file] = self::REMOVED;
            }
            else if ($projectFiles[$file] != $hash)
            {
                $balance[$file] = self::MODIFIED;
            }
            else
            {
                $balance[$file] = self::EQUAL;
            }
        }        

        return $balance;
    }
}