<?php
namespace App\AppServices\Repositories\Order;

/**
 * Get mac addr.
 * User: sai
 * Date: 2018-12-21
 * Time: 21:03
 */
class GetMacAddr
{
    private static $return_array = []; // 返回带有MAC地址的字串数组
    private static $mac_addr;

    public function __construct($os_type=PHP_OS)
    {
        switch ( strtolower($os_type) )
        {
            case 'winnt':
            case 'win32':
            case 'windows':
                self::forWindows();
                break;
            case "linux":
            case "solaris":
            case "unix":
            case "darwin":
            case "aix":
                self::forLinux();
                break;
            default:
                self::forLinux();
                break;
        }

        $temp_array = [];
        foreach ( static::$return_array as $value )
        {
            if ( preg_match( "/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i", $value, $temp_array ) )
            {
                static::$mac_addr = $temp_array[0];
                break;
            }
        }
        unset($temp_array);
        
        return static::$mac_addr;
    }

    /**
     * 把获得的mac addr 经过处理后的string
     *
     * @return string
     */
    public static function getMachineId()
    {
        $mac = md5(static::getMac());
        $mac = static::convertShortString($mac);

        return $mac;
    }

    /**
     * mac addr
     *
     * @return string
     */
    public static function getMac():string
    {
        return static::$mac_addr;
    }

    /**
     * get windows mac addr
     *
     * @return array
     */
    protected static function forWindows()
    {
        @exec("ipconfig /all", static::$return_array);
        if ( static::$return_array )
            return static::$return_array;
        else{
            $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
            if ( is_file($ipconfig) )
                @exec($ipconfig." /all", static::$return_array);
            else
                @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", static::$return_array);
        }
    }

    /**
     * Get linux mac addr
     */
    protected static function forLinux()
    {
        @exec("/sbin/ifconfig -a", static::$return_array);
    }

    /**
     * 把长字符转换为短字符(有一定碰撞机率)
     *
     * @param string $input
     *
     * @return string
     */
    protected static function convertShortString(string $input):string
    {
        $base32 = array (
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
            'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
            'y', 'z', '0', '1', '2', '3', '4', '5'
        );

        $hex = md5($input);
        $hexLen = strlen($hex);
        $subHexLen = $hexLen / 8;
        $output = array();

        for ($i = 0; $i < $subHexLen; $i++) {
            //把加密字符按照8位一组16进制与0x3FFFFFFF(30位1)进行位与运算
            $subHex = substr ($hex, $i * 8, 8);
            $int = 0x3FFFFFFF & hexdec($subHex);
            $out = '';

            for ($j = 0; $j < 6; $j++) {

                //把得到的值与0x0000001F进行位与运算，取得字符数组chars索引
                $val = 0x0000001F & $int;
                $out .= $base32[$val];
                $int = $int >> 5;
            }

            $output[] = $out;
        }

        return array_shift($output);
    }
}