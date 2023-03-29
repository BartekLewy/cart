# Tidio

## Opis
Aplikacja do zarządzania koszykami zakupowymi.

## Wymagania
- Docker
- Docker Compose
- Make

## Instalacja
- `git clone <url>`
- `cp .env.example .env`
- `make build`

Aby wywołać dostępne komendy należy wejść do kontenera z aplikacją:
`make console`

## Dostępne komendy
- `bin/console tidio:carts:create` - tworzy nowy koszyk
- `bin/console tidio:carts:add-item <cart-id>` - dodaje produkt do koszyka
- `bin/console tidio:carts:change <cart-id> <product-id> <quantity>` - zmienia ilość produktów w koszyku
- `bin/console tidio:carts:get <cart-id>` - zwraca informacje o koszyku
- `bin/console tidio:carts:remove <cart-id> <product-id>` - usuwa produkt z koszyka
- `bin/console tidio:products:change-price` - zmienia cenę produktu
- `bin/console tidio:products:create` - tworzy nowy produkt


## Testy
- `make build-test`
- `make test`
- `make deptract`

## Na przyszłość do zrobienia
- [ ] Rest API
- [ ] Dodanie testów integracyjnych na poziomie Cli
- [ ] Dodanie kontekstu użytkownika
- [ ] Rozbudowa modułu product-management
- [ ] Podział testów na testsuites
- [ ] Dodanie wskaźnika pokrycia testów
- [ ] Audyt log dla operacji na koszykach