php-date-time
=============

Tratamento de Data e Hora para PHP.

Extensão do [Carbon 2](https://carbon.nesbot.com/docs/) com validação de entrada, classes
especializadas para data e mês e helpers com nomes simples (`addDay`, `setMonth`, `compareDate`...).

## Requisitos

- PHP 7.2+
- [nesbot/carbon](https://github.com/briannesbitt/Carbon) `^2.18`

## Instalação

```bash
composer require paliari/php-date-time
```

## Classes

| Classe       | Normalização na criação         | `__toString()`        |
|--------------|---------------------------------|-----------------------|
| `TDateTime`  | nenhuma                         | `Y-m-d H:i:s`         |
| `TDate`      | hora zerada (`00:00:00`)        | `Y-m-d H:i:s`         |
| `TDateMonth` | dia 1 e hora zerada             | `m/Y`                 |

Todas estendem `Carbon\Carbon`, então qualquer método do Carbon também está disponível.

## Uso

### Criando datas

```php
use Paliari\DateTime\TDateTime;
use Paliari\DateTime\TDate;
use Paliari\DateTime\TDateMonth;

$dt = new TDateTime('2013-05-01 22:34:21');
$dt = new TDateTime(1367366400);                    // timestamp
$dt = new TDateTime(new DateTime('2013-05-01'));    // DateTime ou qualquer objeto com getTimestamp()
$dt = new TDateTime();                              // agora

(new TDate('2013-05-01 22:34:21'))->toString();     // "2013-05-01 00:00:00"
echo new TDateMonth('2013-05-17 10:00:00');         // "05/2013"
```

Strings são interpretadas por `strtotime()`. Use o formato `Y-m-d` / `Y-m-d H:i:s`:
`xx/xx/yyyy` é lido no formato **americano** (`'05/01/2013'` é 1º de maio).

### Validação

```php
new TDateTime('abc');               // DomainException: "Data abc inválida!"

TDateTime::createDate(null);        // null
TDateTime::createDate('');          // null
TDateTime::createDate('2013-11-07'); // TDateTime

TDateTime::isDate('2013-11-15');    // true
TDateTime::isDate('abc');           // false
```

`createDate()` é útil para valores vindos de formulário/banco que podem estar vazios.

### Formatação

```php
$dt = new TDateTime('2013-05-01 22:34:21');

$dt->toString();         // "2013-05-01 22:34:21"
$dt->toDateString();     // "2013-05-01"
$dt->as_json();          // "2013-05-01T22:34:21"  (alias: to_json())
$dt->format('d/m/Y');    // "01/05/2013"
```

### Getters e setters

```php
$dt = new TDateTime('2013-05-01 22:34:21');

$dt->getYear();     // 2013
$dt->getMonth();    // 5
$dt->getDay();      // 1
$dt->getHour();     // 22
$dt->getMinute();   // 34
$dt->getSecond();   // 21

$dt->setYear(2020)->setMonth(12)->setDay(25)->toDateString(); // "2020-12-25"
// também: setHour(), setMinute(), setSecond()

$dt->firstDayOfMonth()->toString(); // "2020-12-01 00:00:00" (retorna uma cópia)
```

### Aritmética

```php
$dt = new TDateTime('2013-05-01');
$dt->addDay(2)->subHour(3)->toString(); // "2013-05-02 21:00:00"
```

Disponíveis, todos com `$value = 1` por padrão:
`addYear`, `addMonth`, `addDay`, `addHour`, `addMinute`, `addSecond` e os equivalentes `sub*`.

### Comparação (apenas a data, ignorando horas)

```php
$dt = new TDateTime('2013-10-01');

$dt->compareDate(new TDateTime('2013-09-25'));        // 1   (instância é maior)
$dt->compareDate(new TDateTime('2013-10-01 23:00'));  // 0   (mesmo dia)
$dt->compareDate(new TDateTime('2013-10-25'));        // -1  (instância é menor)

$dt->intervalDays(new TDateTime('2013-10-31'));       // "30"

$dt->isFutureDayTo();   // a data é depois de hoje?
$dt->isPastDayTo();     // a data é antes de hoje?
```

Sem argumento, `compareDate()`, `intervalDays()`, `isFutureDayTo()` e `isPastDayTo()`
comparam com a data atual.

## Cuidados

- **As instâncias são mutáveis.** `add*`, `sub*` e `set*` alteram o próprio objeto.
  Use `copy()` para preservar o original:

  ```php
  $inicio = new TDateTime('2013-05-01');
  $fim    = $inicio->copy()->addDay();   // $inicio continua 2013-05-01
  ```

- **Overflow de mês.** `(new TDateTime('2013-01-31'))->addMonth()` resulta em `2013-03-03`.
  Use `addMonthsNoOverflow()` do Carbon quando precisar parar no último dia do mês.
- `intervalDays()` retorna `string` (ex.: `"30"`); faça cast para `int` se necessário.
- `getDayOfYear()` começa em `0` (1º de janeiro = `0`).
- `compare()` está depreciado; use `compareDate()`.

## Desenvolvimento

```bash
composer install
vendor/bin/phpunit                        # suíte completa
vendor/bin/phpunit --exclude-group slow   # pula os testes longos
```

Ambiente Docker (PHP 7):

```bash
docker compose -f docker-compose-cli.yml run --rm cli
```

## Licença

[MIT](LICENSE) © Marcos Paliari
