<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

class PrintfulApiClient
{
    private $client;
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://api.printful.com',
            'headers' => ['Authorization' => 'Bearer ' . $this->apiKey],
            'verify' => false
        ]);
    }

    // Fetch a product by its ID
    public function getProduct($id)
    {
        try {
            $response = $this->client->request('GET', "/products");
            $responseData = json_decode($response->getBody(), true);
            $products = $responseData['result'] ?? [];

            foreach ($products as $product) {
                if (isset($product['id']) && $product['id'] == $id) {
                    $fullDescription = $product['description'];
                    
                    // Find the position of the unwanted string in the response
                    $cutOffPosition = strpos($fullDescription, " • 100% cotton");
                    $description = $cutOffPosition !== false 
                                   ? substr($fullDescription, 0, $cutOffPosition) 
                                   : $fullDescription;

                    return [
                        'id' => $product['id'],
                        'title' => $product['title'],
                        'description' => $description
                    ];
                }
            }

            echo "Product with ID $id not found.\n";
            return null;

        } catch (\Exception $e) {
            echo 'Request failed: ' . $e->getMessage() . "\n";
            return null;
        }
    }

    // Fetch size table for a product
    public function getSizeTable($productId)
    {
        try {
            $response = $this->client->request('GET', "/products/$productId/sizes");
            $data = json_decode($response->getBody(), true);
            $sizeTables = $data['result']['size_tables'] ?? [];
    
            $result = [];
            foreach ($sizeTables as $table) {
                $measurements = [];
                foreach ($table['measurements'] as $measurement) {
                    $valuesArray = [];
                    foreach ($measurement['values'] as $value) {
                        $measurementValue = ['size' => $value['size']];

                        if (isset($value['value'])) {
                            $measurementValue['value'] = $value['value'];
                        } elseif (isset($value['min_value']) && isset($value['max_value'])) {
                            $measurementValue['min_value'] = $value['min_value'];
                            $measurementValue['max_value'] = $value['max_value'];
                        }

                        $valuesArray[] = $measurementValue;
                    }

                    $measurements[] = [
                        'type_label' => $measurement['type_label'],
                        'values' => $valuesArray
                    ];
                }

                $result[] = [
                    'type' => $table['type'],
                    'unit' => $table['unit'],
                    'description' => $table['description'],
                    'measurements' => $measurements
                ];
            }

            return $result;
        } catch (\Exception $e) {
            echo 'Size table request failed: ' . $e->getMessage();
            return null;
        }
    } 
}
?>
