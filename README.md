Nepieciešams:
    Node.js 18.12.1
    Docker 4.14.0
    Composer 2.4.4

Uzstādīšana:
    1. composer install
    2. docker-compose build
    3. docker-compose up -d
    4. izveidot jaunu .env failu no env.example un pielāgot pēc vajadzības 
    5. docker-compose exec cv_crud_app ./artisan migrate
    6. docker-compose exec cv_crud_app ./artisan db:seed
    7. npm install
    8. npm run build
    89. npm run serve

Iecerētais, bet nepagūtais:
    backend ievades lauku validācija
    frontend ievades lauku validācija
    scss kompilēšana
    svg piktogrammas
    pilnīga teksta lokalizācija
    ielādes un pieprasījumu indikatori
    kļūdu paziņojumi
    produkcijai pielāgoti faili
