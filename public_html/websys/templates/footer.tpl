<div id="footer">
  {if $smarty.const.DEBUG_MODE}<span id="footer_info">Debug</span>{/if}
  <span id="footer_block">
   <p><div><strong>{systemConfig::$appName} v{systemConfig::$appVersion}{if $smarty.const.MZZ_REVISION|intval > 0} (r{$smarty.const.MZZ_REVISION}){/if} &copy; {"Y"|date} @ <i><a href="mailto:{systemConfig::$administratorEmail}">{systemConfig::$administrator}</a></i></strong></div>
        {if $smarty.const.DEBUG_MODE}
            <div class="debug">
                {$smarty.const.MZZ_NAME} v.{$smarty.const.MZZ_VERSION};
                Debug Mode: <strong>True</strong>;
            </div>
            <div class="debug">
                {$timer->toString()};
            </div>
            <div class="debug">
                {php}
                try {
                    $backend = cache::factory()->backend();
                    if(systemConfig::$cache['default']['backend'] == 'memcache') {
                        $cacheStats = cache::factory()->backend()->getStats();
                        $keys = array_keys($cacheStats);
                        $bytes = 0;
                        foreach($keys as $key) $bytes += intval($cacheStats[$key]['bytes']);
                    }
                } catch(Exception $ex) {
                    $cacheStats = false;
                }

                echo "Занято RAM: <strong>", convertSize(memory_get_usage()), "</strong>;
                Пик RAM: <strong>", convertSize(memory_get_peak_usage()), "</strong>;
                Кеш [ Тип: <strong>", systemConfig::$cache['default']['backend'], "</strong>;
                ";
                if(systemConfig::$cache['default']['backend'] == 'memcache') {
                    echo "Серверы: <strong>", $cacheStats ? implode(', ', $keys) : "N/A", "</strong>;
                    Кеш память: <strong>", $cacheStats ? convertSize($bytes) : "N/A", "</strong> ];";
                }
                echo "Время на сервере: <strong>", date('d.m.Y H:i:s'), "</strong>";
                {/php}
            </div>
        {/if}
    </p>
   </span>
</div>