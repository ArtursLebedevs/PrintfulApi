<?php
header('Content-Type: application/json');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');

require_once 'vendor/autoload.php'; 
require_once 'PrintfulApiClient.php';
require_once 'FileCache.php';

class ApiHandler {
    private $apiClient;
    private $cache;

    public function __construct($printfulApiKey, $cacheDir) {       
        $this->apiClient = new PrintfulApiClient($printfulApiKey);
        $this->cache = new FileCache($cacheDir);
    }

    public function getProductData($id) {
        $cacheKey = "product_$id";
        $productData = $this->fetchFromCacheOrApi($cacheKey, function() use ($id) {
            return $this->apiClient->getProduct($id);
        });

        if (!$productData) {
            $this->printFailure("Failed to retrieve product data\n");
            return null;
        }

        // Structuring the product data
        $structuredProductData = [
            'id' => $productData['id'],
            'title' => $productData['title'],
            'description' => $productData['description']
        ];

        return ['product' => $structuredProductData];
    }

    public function getSizeTableData($id, $size) {
        $cacheKey = "size_table_{$id}_{$size}";
        $sizeTableData = $this->fetchFromCacheOrApi($cacheKey, function() use ($id, $size) {
            return $this->apiClient->getSizeTable($id, $size);
        });

        if (!$sizeTableData) {
            $this->printFailure("Failed to retrieve size table data for product ID $id and size $size\n");
            return null;
        }

        // Structuring the size table data
        $structuredSizeTableData = array_map(function($table) {
            return [
                'type' => $table['type'],
                'unit' => $table['unit'],
                'description' => $table['description'],
                'measurements' => array_map(function($measurement) {
                    return [
                        'type_label' => $measurement['type_label'],
                        'values' => array_map(function($value) {
                            return [
                                'size' => $value['size'],
                                'value' => $value['value'] ?? $value['min_value'] . '-' . $value['max_value']
                            ];
                        }, $measurement['values'])
                    ];
                }, $table['measurements'])
            ];
        }, $sizeTableData);

        return ['size_table' => $structuredSizeTableData];
    }

    private function fetchFromCacheOrApi($cacheKey, $apiCallback) {     // Gets data either from cache or Api
        
        $data = $this->cache->get($cacheKey);
    
        if ($data === null) {
            
            $data = $apiCallback();
            if ($data) {
                $success = $this->cache->set($cacheKey, $data, 500);    // cache is valid for 5 min
                if ($success) {
                    
                } else {
                    $this->printFailure("Failed to cache data for key '$cacheKey'.");
                }
            }
        } else {
            
        }
    
        return $data;
    }
}

    // Usage
    // New API Key: 0q5l1APl0vkZyKDhjbL9AtbHqBeobQpGXoChI6h8
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); // Handle CORS for cross-origin requests

    $printfulApiKey = '0q5l1APl0vkZyKDhjbL9AtbHqBeobQpGXoChI6h8'; 
    $apiHandler = new apiHandler($printfulApiKey, 'cache');

    $productId = isset($_GET['productID']) ? $_GET['productID'] : null; // Provide a valid product ID here
    $size = isset($_GET['size']) ? $_GET['size'] : null;  // Choose a size for size_data retrieval ( "S", "M", "L", "XL", "2XL", "3XL", "4XL", "5XL" )

    if (!$productId) {
        echo json_encode(['error' => 'Product ID is required']);
        exit;
    }

    $productData = $apiHandler->getProductData($productId);
    $sizeTableData = $size ? $apiHandler->getSizeTableData($productId, $size) : null;

    $response = [
        'productData' => $productData,
        'sizeTableData' => $sizeTableData
    ];

    echo json_encode($response);
?>
