<?php
namespace Src\Model;


class HomeModel {
    private string $file; // Stores the CSV file path

    public function __construct(string $file)
    {
        $this->file = $file; // Initialize with the given CSV file
    }

    // --- Sorting Algorithms ---
    
    // Performs an insertion sort on an array based on a specified key
    private function insertionSort(array $arr, string $key): array
    {
        for ($i = 1; $i < count($arr); $i++) {
            $current = $arr[$i];
            $j = $i - 1;
            while ($j >= 0 && $arr[$j][$key] > $current[$key]) {
                $arr[$j + 1] = $arr[$j];
                $j--;
            }
            $arr[$j + 1] = $current;
        }
        return $arr;
    }

    // Performs a merge sort on an array based on a specified key
    private function mergeSort(array $arr, string $key): array
    {
        if (count($arr) <= 1) return $arr;
        $middle = intdiv(count($arr), 2);
        $left = array_slice($arr, 0, $middle);
        $right = array_slice($arr, $middle);
        $left = $this->mergeSort($left, $key);
        $right = $this->mergeSort($right, $key);
        return $this->merge($left, $right, $key);
    }

    // Merges two sorted arrays based on a key
    private function merge(array $left, array $right, string $key): array
    {
        $result = [];
        while (!empty($left) && !empty($right)) {
            if ($left[0][$key] <= $right[0][$key]) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }
        return array_merge($result, $left, $right);
    }

    // --- CSV Data Handling and Sorting ---

    /**
     * Retrieves sales data from CSV with optional sorting
     * @param string $sort : 'date_asc', 'date_desc', 'quantity_asc', 'quantity_desc', 'price_asc', 'price_desc', 'name_asc', 'name_desc', 'last_name_asc', 'last_name_desc', 'first_name_asc', 'first_name_desc'     * @return array
     */
    public function getSelling(string $sort = 'date_desc'): array
    {
        $rows = [];
        // Open CSV file and read header + data rows
        if (($handle = fopen($this->file, "r")) !== false) {
            $header = fgetcsv($handle, 1000, ",", '"', "\\");
            while (($data = fgetcsv($handle, 1000, ",", '"', "\\")) !== false) {
                $rows[] = array_combine($header, $data);
            }
            fclose($handle);
        }
        $prettyHeader = array_map(function($h) {
        return ucwords(str_replace('_', ' ', $h));
        }, $header);
        // Convert certain fields to proper data types
        foreach ($rows as &$row) {
            if (isset($row['quantity'])) {
                $row['quantity'] = (int)$row['quantity'];
            }
            if (isset($row['unit_price'])) {
                $row['unit_price'] = (float)$row['unit_price'];
            }
            if (isset($row['date'])) {
                $row['date'] = strtotime($row['date']);
            }
        }
        unset($row);
        // Apply sorting based on $sort parameter
        switch ($sort) {
            case 'date_asc':
                usort($rows, fn($a, $b) => $a['date'] <=> $b['date']);
                break;
            case 'date_desc':
                usort($rows, fn($a, $b) => $b['date'] <=> $a['date']);
                break;
            case 'quantity_asc':
                usort($rows, fn($a, $b) => $a['quantity'] <=> $b['quantity']);
                break;
            case 'quantity_desc':
                usort($rows, fn($a, $b) => $b['quantity'] <=> $a['quantity']);
                break;
            case 'price_asc':
                usort($rows, fn($a, $b) => $a['unit_price'] <=> $b['unit_price']);
                break;
            case 'price_desc':
                usort($rows, fn($a, $b) => $b['unit_price'] <=> $a['unit_price']);
                break;
            case 'name_asc':
                usort($rows, fn($a, $b) => $a['name_product'] <=> $b['name_product']);
                break;
            case 'name_desc':
                usort($rows, fn($a, $b) => $b['name_product'] <=> $a['name_product']);
                break;
            case 'last_name_asc':
                usort($rows, fn($a, $b) => $a['last_name'] <=> $b['last_name']);
                break;
            case 'last_name_desc':
                usort($rows, fn($a, $b) => $b['last_name'] <=> $a['last_name']);
                break;
            case 'first_name_asc':
                usort($rows, fn($a, $b) => $a['first_name'] <=> $b['first_name']);
                break;
            case 'first_name_desc':
                usort($rows, fn($a, $b) => $b['first_name'] <=> $a['first_name']);
                break;
            case 'email_asc':
                usort($rows, fn($a, $b) => $a['email'] <=> $b['email']);
                break;
            case 'email_desc':
                usort($rows, fn($a, $b) => $b['email'] <=> $a['email']);
                break;
            case 'insertion':
                if (strpos($this->file, 'selling_data.csv') !== false) {
                    $rows = $this->insertionSort($rows, 'quantity');
                }elseif (strpos($this->file, 'user_data.csv') !== false) {
                $rows = $this->insertionSort($rows, 'last_name'); 
                }
                break;
            case 'merge':
                if (strpos($this->file, 'selling_data.csv') !== false) {
                    $rows = $this->mergeSort($rows, 'unit_price');
                }elseif (strpos($this->file, 'user_data.csv') !== false) {
                    $rows = $this->mergeSort($rows, 'first_name');
                }
                break;
            default:   
                if (strpos($this->file, 'selling_data.csv') !== false) {
                    usort($rows, fn($a, $b) => $b['date'] <=> $a['date']);
                } elseif (strpos($this->file, 'user_data.csv') !== false) {
                    usort($rows, fn($a, $b) => $a['last_name'] <=> $b['last_name']); 
                } else {
                    usort($rows, fn($a, $b) => $a[key($a)] <=> $b[key($b)]);
                }
                break;
        }
        if (strpos($this->file, 'selling_data.csv') !== false) {
            foreach ($rows as &$row) {
            $row['date'] = date("Y-m-d", $row['date']);
        }
        }
        return [$prettyHeader, $rows];
    }

    // --- Statistics Generation ---
    public function getStats(): array
    {
        $rows = [];
        // Open CSV file and read all rows
        if (($handle = fopen($this->file, "r")) !== false) {
            $header = fgetcsv($handle, 1000, ",", '"', "\\");
            while (($data = fgetcsv($handle, 1000, ",", '"', "\\")) !== false) {
                $rows[] = array_combine($header, $data);
            }
            fclose($handle);
        }
        // Initialize statistics arrays
        $stats = [
            'total_sales' => count($rows),
            'products' => [],
            'dates' => [],
        ];
        foreach ($rows as $row) {
            $quantity = (int)$row['quantity'];
            $price = (float)$row['unit_price'];
            $product = $row['name_product'];
            $date = $row['date'];
            if (!isset($stats['products'][$product])) {
                $stats['products'][$product] = [
                    'quantity' => 0,
                    'revenue' => 0,
                    'count' => 0,
                ];
            }
            // Aggregate statistics per product and per date
            $stats['products'][$product]['quantity'] += $quantity;
            $stats['products'][$product]['revenue'] += $quantity * $price;
            $stats['products'][$product]['count']++;
            if (!isset($stats['dates'][$date])) {
                $stats['dates'][$date] = 0;
            }
            $stats['dates'][$date] += $quantity;
        }
        // Identify top product by quantity sold
        $topProductByQuantity = null;
        if (!empty($stats['products'])) {
            $maxQuantity = max(array_column($stats['products'], 'quantity'));
            foreach ($stats['products'] as $name => $data) {
                if ($data['quantity'] === $maxQuantity) {
                    $topProductByQuantity = $name;
                    break;
                }
            }
        }
        // Identify top product by revenue
        $topProductByRevenue = null;
        if (!empty($stats['products'])) {
            $maxRevenue = max(array_column($stats['products'], 'revenue'));
            foreach ($stats['products'] as $name => $data) {
                if ($data['revenue'] === $maxRevenue) {
                    $topProductByRevenue = $name;
                    break;
                }
            }
        }
        // Identify top sales date
        $topDate = null;
        if (!empty($stats['dates'])) {
            $maxDate = max($stats['dates']);
            $topDate = array_search($maxDate, $stats['dates']);
        }
        return [
            'Total sales' => $stats['total_sales'],
            'Top product quantity' => $topProductByQuantity,
            'Top product revenue' => $topProductByRevenue,
            'Top date' => $topDate,
            'Products' => $stats['products'],
        ];
    }
}
?>
