# NEM決済プラグイン 拡張サンプル

EC-CUBE 3.0向けのNEM決済プラグインを拡張するサンプルプラグインです。

## ライセンス

MIT

## 免責事項

本ソフトウェアはサンプルプログラムです。使用者の責任において利用して下さい。

このプログラムによって発生した、いかなる障害・損害も作成者は一切責任を負わないものとします。

## 拡張方法

1. Exchangerを作成する。

    - [daisy-link/exchanger](https://packagist.org/packages/daisy-link/exchanger)の```DaisyLink\Exchanger\ExchangerInterface```を実装したクラスを作成する。
    - レート取得時や算出時に```DaisyLink\Exchanger\Exception\ExchangerException```をスローすると、レート取得不可としてハンドリングされます。
    - Zaif APIから最新のレートを取得するサンプル: ```src/Nem/Exchange/XemJpyZaifExchanger.php```
    
2. Exchangerを登録する。

    - 2.で作成したクラスのオブジェクトをサービスプロバイダで登録する。
    - サンプル: ```src/ServiceProvider/ServiceProvider.php```
    
## その他

EC-CUBE 開発ドキュメント・マニュアル http://doc.ec-cube.net/
