<?php
echo "Test OK - Backend PHP funciona";
echo "\n";
echo "Path actual: " . __DIR__;
echo "\n";
echo "Archivos en este directorio:\n";
print_r(scandir(__DIR__));
