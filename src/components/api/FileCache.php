<?php
require_once 'CacheInterface.php';

class FileCache implements CacheInterface
{
    private $cacheDir;

    public function __construct($cacheDir = 'cache')
    {
        $this->cacheDir = $cacheDir;
        // Create the cache directory if it doesn't exist
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    // Set a value in the cache
    public function set(string $key, $value, int $duration)
    {
        $filePath = $this->getCacheFilePath($key);
        $data = serialize([
            'value' => $value,
            'expires_at' => time() + $duration // Calculate expiration time
        ]);

        // Write the data to a file 
        return file_put_contents($filePath, $data) !== false;
    }

    // Retrieve value from the cache
    public function get(string $key)
    {
        $filePath = $this->getCacheFilePath($key);
        if (!file_exists($filePath)) {
            return null;
        }

        $data = @unserialize(file_get_contents($filePath));
        // Check if data is not valid or expired, then delete the file
        if (!$data || time() > $data['expires_at']) {
            unlink($filePath);
            return null;
        }

        // Return the cached value
        return $data['value'];
    }

    // Generate the cache file path 
    private function getCacheFilePath($key)
    {
        return $this->cacheDir . '/' . md5($key);
    }
}
?>
