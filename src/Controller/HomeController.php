<?php

namespace Src\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Src\Model\HomeModel;



class HomeController
{
    private $twig; // Twig templating engine instance

    public function __construct()
    {
        // Initialize Twig loader to read templates from /View directory
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }

    // --- Controller Methods ---

    // Render the main homepage
    public function home(){
        echo $this->twig->render('home.html.twig', ['currentPath' => '/']);
    }
    
    // Display the selling data page
    public function homeSelling()
    {
        // Load user CSV data
        $csvPath = __DIR__ . '/../../public/assets/data/selling_data.csv';
        $homeModel = new HomeModel($csvPath);

        // Get sorting option from query parameters (default to 'date_desc')
        $sort = $_GET['sort'] ?? 'date_desc';

        // Fetch sorted data from the model
        $data = $homeModel->getSelling($sort);

        // List of sortable columns for the frontend UI
        $sortable_columns = ['date_asc', 'date_desc', 'quantity_asc', 'quantity_desc', 
        'price_asc', 'price_desc', 'name_asc', 'name_desc', 'insertion', 'merge'];

        // Render the Twig template with data, headers, sorting info, and path
        echo $this->twig->render('home_selling.html.twig', ['title' => 'Manage selling', 'headers' => $data[0], 'data' => $data[1], 'sort' => $sort, 'path' => '/selling', 'sortable_columns' => $sortable_columns]);
    }

    // Display the user data page
    public function homeUser()
    {
        // Load user CSV data
        $csvPath = __DIR__ . '/../../public/assets/data/user_data.csv';
        $homeModel = new HomeModel($csvPath); 

        // Get sorting option from query parameters (default to 'last_name')
        $sort = $_GET['sort'] ?? 'last_name';

        // Fetch sorted data from the model
        $data = $homeModel->getSelling($sort);

        // List of sortable columns for users
        $sortable_columns = ['last_name_asc', 'last_name_desc', 'first_name_asc', 'first_name_desc', 
        'email_asc', 'email_desc', 'insertion', 'merge'];

        // Render the template with user data
        echo $this->twig->render('home_selling.html.twig', ['title' => 'Manage client', 'headers' => $data[0], 'data' => $data[1], 'sort' => $sort, 'path' => '/user', 'sortable_columns' => $sortable_columns]);
    }

    // Display sales statistics
    public function homeStatistic()
    {
        // Load selling CSV data
        $csvPath = __DIR__ . '/../../public/assets/data/selling_data.csv';
        $homeModel = new HomeModel($csvPath);

        // Fetch aggregated statistics
        $data = $homeModel->getStats();

        // Render the statistics template
        echo $this->twig->render('home_statistic.html.twig', ['data' => $data]);
    }


    

    

}
?>
