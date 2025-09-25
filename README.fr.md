[English 🇬🇧](README.md)

# 📊 Projet PHP - Gestion des ventes et utilisateurs

Ce projet est une **petite application PHP** utilisant **Twig** comme moteur de template.  

👉 L’objectif n’est **pas** de développer une application complète, mais :  
- de **manipuler des fichiers CSV**,  
- de **mettre en pratique le modèle MVC**,  
- et de **découvrir l’utilisation de Twig** pour séparer la logique et la présentation.  

L’application permet ainsi de **visualiser, trier et analyser** des données provenant de fichiers **CSV** (`selling_data.csv` et `user_data.csv`).

---

## 🚀 Fonctionnalités

- **Accueil** : Page principale d’introduction.
- **Ventes (`/selling`)** :
  - Lecture du fichier `selling_data.csv`
  - Affichage des ventes sous forme de tableau
  - Tri possible sur plusieurs colonnes (date, quantité, prix, nom du produit, etc.)
  - Tri personnalisé via **Insertion Sort** ou **Merge Sort**
- **Utilisateurs (`/user`)** :
  - Lecture du fichier `user_data.csv`
  - Affichage des utilisateurs sous forme de tableau
  - Tri possible (nom, prénom, email, etc.)
  - Tri personnalisé via **Insertion Sort** ou **Merge Sort**
- **Statistiques (`/statistic`)** :
  - Nombre total de ventes
  - Produit le plus vendu (quantité)
  - Produit générant le plus de revenus
  - Date avec le plus de ventes
  - Détail des produits (quantité, revenus, nombre de ventes)

---

## 🏗️ Architecture

📂 src  
┣ 📂 Controller  
┃ ┗ 📜 HomeController.php # Gère le lien entre les vues et le model  
┣ 📂 Model  
┃ ┗ 📜 HomeModel.php # Gère la lecture CSV, le tri et les statistiques  
┣ 📂 View  
┃ ┣ 📜 home.html.twig  
┃ ┣ 📜 home_selling.html.twig  
┃ ┗ 📜 home_statistic.html.twig  
📂 public  
┣ 📜index.php # Gère les routes et la logique  
┣ 📂 assets  
┃ ┗ 📂 data  
┃ ┣ 📜 selling_data.csv  
┃ ┗ 📜 user_data.csv  
┃ ┗ 📂 js # Gère le bouton de tri et la soumission du formulaire  
┃ ┗ 📂 css # Gère la mise en page  

---

## ⚙️ Installation et utilisation

1. **Cloner le projet**
   ```bash
   git clone https://github.com/ton-compte/ton-projet.git
   cd ton-projet
   ```
   
2. **Installer les dépendances**
Assurez-vous d’avoir Composer installé, puis lancez :
```bash
composer install
```

Lancer un serveur PHP
```bash
php -S localhost:8000 -t public
```

Accéder à l’application
```bash
Accueil : http://localhost:8000
```

---

## 📌 Technologies utilisées
- PHP 8+
- Twig (moteur de templates)
- Composer
- HTML / CSS / JavaScript
- CSV comme source de données
