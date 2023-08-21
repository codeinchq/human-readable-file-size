# Human readable file size

This PHP 7 library, strongly inspired by [Jeffrey Sambells' blog post](http://jeffreysambells.com/2012/10/25/human-readable-filesize-php),
computes a size in bytes in a human readable form. 


## Installation
This library is available through [Packagist](https://packagist.org/packages/codeinc/human-readable-file-size) 
and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/human-readable-file-size
```


## Usage 

### Simple usage

```php
<?php
use CodeInc\HumanReadableFileSize\HumanReadableFileSize;

echo HumanReadableFileSize::getHumanSize(filesize('a-file.pdf'));
// outputs 2.88MB 

echo HumanReadableFileSize::getHumanSize(filesize('a-file.pdf'), 1);
// outputs 2.9MB 

echo HumanReadableFileSize::getHumanSize(filesize('a-file.pdf'), 0);
// outputs 3MB
```

### Full configuration usage

```php
<?php
use CodeInc\HumanReadableFileSize\HumanReadableFileSize;

$readableSize = new HumanReadableFileSize();
$readableSize->useNumberFormatter('fr-FR');
$readableSize->setSpaceBeforeUnit();
$readableSize->setByteSymbol('o');
echo $readableSize->compute(filesize('a-file.pdf'), 1);
// outputs 2,9 Mo 
```

## License
This library is published under the MIT license (see the [LICENSE](LICENSE) file). 

