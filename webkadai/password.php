<?php
/**
* PHP 5.5 の簡素化されたパスワード ハッシュ API との互換性ライブラリ。
*
* @author Anthony Ferrara <ircmaxell@php.net>
* @license http://www.opensource.org/licenses/mit-license.html MIT ライセンス
* @copyright 2012 著者
*/

名前空間{

    if (!defined( 'PASSWORD_BCRYPT' )) {
        /**
         * PHPUnit プロセス分離は定数をキャッシュしますが、関数宣言はキャッシュしません。
         * そのため、定数が個別に定義されているかどうかを確認する必要があります。
         * ユーザーランドでのプロセス分離をサポートできるようにする関数
         * コード。
         */
        define( 'PASSWORD_BCRYPT' , 1 );
        define( 'PASSWORD_DEFAULT' , PASSWORD_BCRYPT );
        define( 'PASSWORD_BCRYPT_DEFAULT_COST' , 10 );
    }

    if (!function_exists( 'password_hash' )) {

        /**
         * 指定されたアルゴリズムを使用してパスワードをハッシュする
         *
         * @param string $password ハッシュするパスワード
         * @param int $algo 使用するアルゴリズム (PASSWORD_* 定数で定義)
         * @param array $options 使用するアルゴリズムのオプション
         *
         * @return string|false ハッシュされたパスワード、またはエラーの場合は false。
         */
        function  password_hash ( $ password , $ algo , array  $ options = array ()) {
            if (!function_exists( 'crypt' )) {
                trigger_error(" password_hash を機能させるには暗号をロードする必要があります", E_USER_WARNING );
                 nullを返します。
            }
            if (is_null( $ password ) || is_int( $ password )) {
                $ password = (文字列) $ password ;
            }
            if (!is_string( $ password )) {
                trigger_error(" password_hash(): パスワードは文字列でなければなりません", E_USER_WARNING );
                 nullを返します。
            }
            if (!is_int( $ algo )) {
                trigger_error(" password_hash () は、パラメーター 2 が長いことを期待しています。
                 nullを返します。
            }
            $結果の長さ= 0 ;
            スイッチ( $アルゴ) {
                ケース PASSWORD_BCRYPT :
                    $コスト= PASSWORD_BCRYPT_DEFAULT_COST ;
                    if (isset( $オプション[ 'コスト' ])) {
                        $コスト= ( int ) $オプション[ 'コスト' ];
                        if ( $コスト< 4 || $コスト> 31 ) {
                            trigger_error(sprintf(" password_hash(): 無効な bcrypt コスト パラメータが指定されました: %d ", $ cost ), E_USER_WARNING );
                             nullを返します。
                        }
                    }
                    // 生成するソルトの長さ
                    $ raw_salt_len = 16 ;
                    // 最終シリアライズに必要な長さ
                    $ required_salt_len = 22 ;
                    $ hash_format = sprintf(" $2y$%02d$ ", $コスト);
                    // 最終的な crypt() 出力の予想される長さ
                    $ resultLength = 60 ;
                    休憩;
                デフォルト:
                    trigger_error(sprintf(" password_hash(): 不明なパスワード ハッシュ アルゴリズム: %s ", $ algo ), E_USER_WARNING );
                     nullを返します。
            }
            $ salt_req_encoding = false ;
            if (isset( $オプション[ 'salt' ])) {
                スイッチ(gettype( $オプション[ 'salt' ])) {
                    ケース 「ヌル」：
                    ケース 「ブール値」 :
                    ケース 「整数」 :
                    ケース 「ダブル」：
                    ケース 「文字列」 :
                        $ salt = (文字列) $ options [ 'salt' ];
                        休憩;
                    ケース 「オブジェクト」 :
                        if (method_exists( $ options [ 'salt' ], '__tostring' )) {
                            $ salt = (文字列) $ options [ 'salt' ];
                            休憩;
                        }
                    ケース 「配列」 :
                    ケース 「リソース」 :
                    デフォルト:
                        trigger_error( 'password_hash(): 非文字列のソルト パラメータが指定されました' , E_USER_WARNING );
                         nullを返します。
                }
                if ( PasswordCompat \binary\_strlen ( $ salt ) < $ required_salt_len ) {
                    trigger_error(sprintf(" password_hash(): 指定されたソルトが短すぎます: %d 期待 %d ", PasswordCompat \binary\_strlen ( $ salt ), $ required_salt_len ), E_USER_WARNING );
                     nullを返します。
                } elseif ( 0 == preg_match( '#^[a-zA-Z0-9./]+$#D' , $ salt )) {
                    $ salt_req_encoding = true ;
                }
            }その他{
                $バッファ= '' ;
                $ buffer_valid = false ;
                if (function_exists( 'mcrypt_create_iv' ) && !defined( 'PHALANGER' )) {
                    $ buffer = mcrypt_create_iv( $ raw_salt_len , MCRYPT_DEV_URANDOM );
                    if ( $バッファ) {
                        $ buffer_valid = true ;
                    }
                }
                if (! $ buffer_valid && function_exists( 'openssl_random_pseudo_bytes' )) {
                    $強い=偽;
                    $ buffer = openssl_random_pseudo_bytes( $ raw_salt_len , $ strong );
                    if ( $バッファ&& $強い) {
                        $ buffer_valid = true ;
                    }
                }
                if (! $ buffer_valid && @is_readable( '/dev/urandom' )) {
                    $ file = fopen( '/dev/urandom' , 'r' );
                    $読み取り= 0 ;
                    $ local_buffer = '' ;
                    while ( $ read < $ raw_salt_len ) {
                        $ local_buffer .= fread( $ file , $ raw_salt_len - $ read );
                        $ read = PasswordCompat \binary\_strlen ( $ local_buffer );
                    }
                    fclose( $ファイル);
                    if ( $ read >= $ raw_salt_len ) {
                        $ buffer_valid = true ;
                    }
                    $ buffer = str_pad( $ buffer , $ raw_salt_len , "\0") ^ str_pad( $ local_buffer , $ raw_salt_len , "\0");
                }
                if (! $ buffer_valid || PasswordCompat \binary\_strlen ( $ buffer ) < $ raw_salt_len ) {
                    $ buffer_length = PasswordCompat \binary\_strlen ( $ buffer );
                    for ( $ i = 0 ; $ i < $ raw_salt_len ; $ i ++) {
                        if ( $ i < $ buffer_length ) {
                            $ buffer [ $ i ] = $ buffer [ $ i ] ^ chr(mt_rand( 0 , 255 ));
                        }その他{
                            $ buffer .= chr(mt_rand( 0 , 255 ));
                        }
                    }
                }
                $塩= $バッファ;
                $ salt_req_encoding = true ;
            }
            if ( $ salt_req_encoding ) {
                // crypt で使用される Base64 バリアントで文字列をエンコードします
                $ base64_digits =
                    'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/' ;
                $ bcrypt64_digits =
                    './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789' ;

                $ base64_string = base64_encode( $ salt );
                $ salt = strtr(rtrim( $ base64_string , '=' ), $ base64_digits , $ bcrypt64_digits );
            }
            $ salt = PasswordCompat \binary\_substr ( $ salt , 0 , $ required_salt_len );

            $ hash = $ hash_format . $塩;

            $ ret = crypt( $パスワード, $ハッシュ);

            if (!is_string( $ ret ) || PasswordCompat \binary\_strlen ( $ ret ) != $ resultLength ) {
                 偽を返します。
            }

             $ retを返します。
        }

        /**
         * パスワード ハッシュに関する情報を取得します。情報の配列を返します
         * パスワード ハッシュの生成に使用されたもの。
         *
         * 配列（
         * 'アルゴリズム' => 1,
         * 'algoName' => 'bcrypt',
         * 'オプション' => 配列(
         * 'コスト' => PASSWORD_BCRYPT_DEFAULT_COST,
         * )、
         * )
         *
         * @param string $hash 情報を抽出するためのパスワード ハッシュ
         *
         * @return array ハッシュに関する情報の配列。
         */
        function  password_get_info ( $ハッシュ) {
            $リターン=配列(
                「アルゴリズム」 => 0、
                'アルゴリズム名' => '不明' ,
                'オプション' =>配列(),
            );
            if ( PasswordCompat \binary\_substr ( $ハッシュ, 0 , 4 ) == '$2y$' && PasswordCompat \binary\_strlen ( $ハッシュ) == 60 ) {
                $ return [ 'algo' ] = PASSWORD_BCRYPT ;
                $ return [ 'algoName' ] = 'bcrypt' ;
                list ( $ cost ) = sscanf( $ hash , " $2y$%d$ ");
                $ return [ 'options' ][ 'cost' ] = $ cost ;
            }
             $リターンを返します。
        }

        /**
         *提供されたオプションに従って、パスワードハッシュを再ハッシュする必要があるかどうかを判断します
         *
         * 答えが true の場合、password_verify を使用してパスワードを検証した後、再ハッシュします。
         *
         * @param string $hash テストするハッシュ
         * @param int $algo 新しいパスワード ハッシュに使用されるアルゴリズム
         * @param array $options password_hash に渡されるオプション配列
         *
         * @return boolean パスワードを再ハッシュする必要がある場合は true。
         */
        function  password_needs_rehash ( $ hash , $ algo , array  $ options = array ()) {
            $ info = password_get_info( $ hash );
            if ( $情報[ 'アルゴリズム' ] !== ( int ) $アルゴ) {
                 真を返します。
            }
            スイッチ( $アルゴ) {
                ケース PASSWORD_BCRYPT :
                    $コスト= isset( $オプション[ 'コスト' ]) ? ( int ) $オプション[ 'コスト' ] : PASSWORD_BCRYPT_DEFAULT_COST ;
                    if ( $コスト!== $情報[ 'オプション' ][ 'コスト' ]) {
                         真を返します。
                    }
                    休憩;
            }
             偽を返します。
        }

        /**
         * タイミング攻撃耐性アプローチを使用して、ハッシュに対してパスワードを検証します
         *
         * @param string $password 確認するパスワード
         * @param string $hash 照合するハッシュ
         *
         * @return boolean パスワードがハッシュと一致する場合
         */
        関数 password_verify ( $パスワード, $ハッシュ) {
            if (!function_exists( 'crypt' )) {
                trigger_error(" password_verify を機能させるには暗号をロードする必要があります", E_USER_WARNING );
                 偽を返します。
            }
            $ ret = crypt( $パスワード, $ハッシュ);
            if (!is_string( $ ret ) || PasswordCompat \binary\_strlen ( $ ret ) != PasswordCompat \binary\_strlen ( $ hash ) || PasswordCompat \binary\_strlen ( $ ret ) <= 13 ) {
                 偽を返します。
            }

            $ステータス= 0 ;
            for ( $ i = 0 ; $ i < PasswordCompat \binary\_strlen ( $ ret ); $ i ++) {
                $ status |= (ord( $ ret [ $ i ]) ^ ord( $ hash [ $ i ]));
            }

             $ステータス=== 0を返します。
        }
    }

}

名前空間 PasswordCompat \binary {

    if (!function_exists( 'PasswordCompat\\binary\\_strlen' )) {

        /**
         * 文字列のバイト数を数える
         *
         * mbstring 拡張によって上書きされる可能性があるため、単純に strlen() を使用することはできません。
         * この場合、strlen() は内部エンコーディングに基づいて *文字* の数をカウントします。あ
         * 一連のバイトは単一のマルチバイト文字と見なされる場合があります。
         *
         * @param string $binary_string 入力文字列
         *
         * @内部
         * @return int バイト数
         */
        関数 _strlen ( $バイナリ文字列) {
            if (function_exists( 'mb_strlen' )) {
                return mb_strlen( $ binary_string , '8bit' );
            }
            return strlen( $ binary_string );
        }

        /**
         * バイト制限に基づいて部分文字列を取得する
         *
         * @see _strlen()
         *
         * @param string $binary_string 入力文字列
         * @param int $start
         * @param int $length
         *
         * @内部
         * @return string 部分文字列
         */
        function  _substr ( $ binary_string , $ start , $ length ) {
            if (function_exists( 'mb_substr' )) {
                return mb_substr( $ binary_string , $ start , $ length , '8bit' );
            }
            return substr( $ binary_string , $ start , $ length );
        }

        /**
         * 現在の PHP バージョンがライブラリと互換性があるかどうかを確認します
         *
         * @return boolean チェック結果
         */
        関数 チェック() {
            static  $ pass = NULL ;

            if (is_null( $ pass )) {
                if (function_exists( 'crypt' )) {
                    $ハッシュ= '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG' ;
                    $ test = crypt("パスワード", $ハッシュ);
                    $ pass = $ test == $ hash ;
                }その他{
                    $パス=偽;
                }
            }
             $パスを返します。
        }

    }
}