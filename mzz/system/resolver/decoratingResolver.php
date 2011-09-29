<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/resolver/decoratingResolver.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: decoratingResolver.php 2182 2007-11-30 04:41:35Z zerkms $
 */

/**
 * decoratingResolver: реализация паттерна decorator для резолверов
 * от него наследуются все декорирующий резолверы
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
abstract class decoratingResolver implements iResolver
{
    /**
     * резолвер, который будет декорироваться
     *
     * @var object
     */
    protected $resolver = null;

    /**
     * конструктор
     *
     * @param object $resolver резолвер, который будет декорироваться
     */
    public function __construct(iResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * замещаем метод resolve для декорируемого резолвера
     * в наследниках также будет происходить декорирование
     *
     * @param string $request запрос
     * @return string|null путь до файла если найден, либо null в противном случае
     */
    public function resolve($request)
    {
        return $this->resolver->resolve($request);
    }

    /**
     * замещаем все методы декорируемого резолвера
     *
     * @param string $callname имя метода
     * @param array $args аргументы
     * @return mixed результаты выполнения замещаемого метода
     */
    public function __call($callname, $args)
    {

        $callback = array($this->resolver, $callname);

        if (!is_callable($callback)) {
            throw new mzzCallbackException($callback);
        }

        return call_user_func_array($callback, $args);

    }
}

?>