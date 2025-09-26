[Français 🇫🇷](README.fr.md)

# 📊 Project PHP - Sales and user management

This project is a **small PHP application** using **Twig** as its template engine.  

👉 The objective is **not** to develop a complete application, but rather:  
- to handle CSV files,  
- to **put the MVC model into practice**,  
- and **discover how to use Twig** to separate logic and presentation.  

The application allows you to **view, sort and analyse** data from **CSV** files (`selling_data.csv` and `user_data.csv`).

---

## 🚀 Features

- **Home**: Main introductory page.
- **Sales (`/selling`)** :
  - Reading the file `selling_data.csv`
  - Displaying sales in tabular form
  - Sorting possible on several columns (date, quantity, price, product name, etc.)
  - Custom sorting via **Insertion Sort** ou **Merge Sort**
- **Users (`/user`)** :
  - Reading the file `user_data.csv`
  - Displaying users in tabular form
  - Sorting possible (last name, first name, email, etc.)
  - Custom sorting via **Insertion Sort** ou **Merge Sort**
- **Statistic (`/statistic`)** :
  - Total number of sales
  - Best-selling product (quantity)
  - Product generating the most revenue
  - Date with the highest sales
  - Product details (quantity, revenue, number of sales)

---

## 🏗️ Architecture

📂 src  
┣ 📂 Controller  
┃ ┗ 📜 HomeController.php # Manages the link between views and the model  
┣ 📂 Model  
┃ ┗ 📜 HomeModel.php # Manages CSV reading, sorting, and statistics  
┣ 📂 View  
┃ ┣ 📜 home.html.twig  
┃ ┣ 📜 home_selling.html.twig  
┃ ┗ 📜 home_statistic.html.twig  
📂 public  
┣ 📜index.php # Manages routes and logic  
┣ 📂 assets  
┃ ┗ 📂 data  
┃ ┣ 📜 selling_data.csv  
┃ ┗ 📜 user_data.csv  
┃ ┗ 📂 js # Manages the sort button and form submission  
┃ ┗ 📂 css # Manages the layout  

---

## ⚙️ Installation and use

1. **Clone the project**
   ```bash
   git clone https://github.com/ton-compte/ton-projet.git
   cd ton-projet
   ```
   
2. **Install dependencies**
Ensure you have Composer installed, then run:
```bash
composer install
```

Starting a PHP server
```bash
php -S localhost:8000 -t public
```

Access the application
```bash
Accueil : http://localhost:8000
```

---

## 📌 Technologies utilisées
- PHP 8+
- Twig (template engine)
- Composer
- HTML / CSS / JavaScript
- CSV as a data source
