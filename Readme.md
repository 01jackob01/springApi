# Server install
```
docker build -t server_api .
docker-compose up -d
```

# API

### New package

``http://localhost/spring.php?api=new_package``

Tworzy przesyłkę z domyśłnymi danymi z pliku spring.php

### Get package PDF

``http://localhost/spring.php?api=get_label``

Pobiera etykietę z domyślnych danych z pliku spring.php

### Execute api from web browser

``http://localhost/index.php``

Wyświetla wszystie dostępne pola dla api, podczas ładowania strony wczytuje domyślne wartości z pliku spring.php

# Php Unit

Odpalanie przez plik ``executeTests.sh``