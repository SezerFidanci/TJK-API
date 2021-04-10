# TJK-API
Türkiye Jokey Kulübü (TJK) API

TJK'nın resmi sitesinden anlık olarak çekilen, yarış bülteni ve yarış sonuçları.


#### Kurulum
```sh
$ composer require sezerfidanci/tjkapi
```

#### Kullanım
```php
use TJK\TJK;

$tjkAPI = new TJK();

$tjkAPI->getTodayRaces();
```

#### Fonksiyonlar

Bugün Yapılacak Yarışlar

```php
$tjkAPI->getTodayRaces();
```

Belirli Bir Tarihte Yapılan Yarışlar
```php
$date = '20210410';

$tjkAPI->getRacesByDate($date);
```

Bugün Yapılan Yarış Sonuçları
```php
$tjkAPI->getTodayResult();
```


Belirli Bir Tarihte Yapılan Yarış Sonuçlar
```php
$date = '20210410';

$tjkAPI->getResultByDate($date);
```

#### Örnek Sonuç

```json
{"status":true,"code":200,"data":[{"KEY":"ADANA","AD":"Yeşiloba Hipodromu","YER":"Adana","GUN":"43","RACE":{}}]}
```
