# Legator Digital Dashboard

Welcome to the Legator Digital Dashboard! This dashboard provides a user-friendly interface for managing various features.

## Getting Started

Follow these steps to get the website up and running on your local machine.

### Prerequisites

1. [XAMPP](https://www.apachefriends.org/index.html) - Download and install XAMPP, which includes Apache and MySQL.

### Installation

1. Clone or download the Git repository.

    ```bash
    git clone https://github.com/Realgorithm/legator.git
    ```

2. Extract the downloaded ZIP file.

3. Move the extracted folder to the `htdocs` directory in your XAMPP installation folder.

    ```bash
    mv legator /path/to/xampp/htdocs/
    ```

### Database Setup

1. Open XAMPP and start both Apache and MySQL.

2. Open your browser and navigate to [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/).

3. Create a new database. You can name it `legator` or choose a name of your preference.

4. Import the provided SQL file (`database.sql`) into the newly created database. This file contains the necessary tables and initial data.

### Run the Website

1. Open your browser and go to [http://localhost/legator/](http://localhost/legator/).

2. You should now see the Legator Digital Dashboard.

### Accessing the Website

- Username: admin
- Password: admin123

## Usage

Explore the various features and functionalities of the Legator Digital Dashboard.

## Contributing

If you'd like to contribute to this project, feel free to fork the repository and submit pull requests.

## License

This project is licensed under the [MIT License](LICENSE).
