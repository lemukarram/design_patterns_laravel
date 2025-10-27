 The Singleton Pattern is a creational design pattern

the main goal of Singleton is To ensure that only one object of a 
particular class exists throughout the entire execution of an application,
 providing a single point of access to that instance.


A  Singleton implementation involves three specific steps
that prevent from creating multiple objects of a singleton class.

Make the constructor private, it does not allow to create 
object of this class by using new keyword from outside the class.

A Private Static Variable that Stores the single instance of the class 
we usually named it $instance.

A Public Static Method getInstance, it is the only way to access the instance. 
It checks if the instance not exists,  it creates the object, and then returns 
the stored instance.


in Laravel, the Service Container handles the Singleton behavior.

Instead of writing all the private constructor logic, you simply 
tell the Service Container to treat a class as a singleton using a singleton 
binding.


some commond use cases of singleton are 
Database Connection
Centerilize Logs
site Configration
Cache system,
and Language translator
you can use Signleton where need one consistent object across the request.


app/Services/CurrencyConverter.php
<?
namespace App\Services;
class CurrencyConverter
{
    private static $instance = null;
    private function __construct() {} //Private
    public static function getInstance(): self //static method
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function convert(float $amount, string $from, string $to): float
    {
        // Simple conversion logic (e.g., a dummy rate)
        if ($from === 'USD' && $to === 'EUR') {
            return $amount * 0.92;
        }
        return $amount;
    }
}
?>

// In any PHP script or non-Laravel code:
<?php
use App\Services\CurrencyConverter;

$converter1 = CurrencyConverter::getInstance();
$result1 = $converter1->convert(100, 'USD', 'EUR');
echo "Converted amount 1: " . $result1 . "\n";

$converter2 = CurrencyConverter::getInstance();
$result2 = $converter2->convert(50, 'USD', 'EUR');
echo "Converted amount 2: " . $result2 . "\n";

// This will always be true, proving it's the same instance:
if ($converter1 === $converter2) {
    echo "Both variables hold the same instance.\n";
}
?>


//IN Laravel
app/Providers/CurrencyConverterServiceProvider.php
<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Support\ServiceProvider;

class CurrencyConverterServiceProvider extends ServiceProvider
{
    /**
     * Register services with the container.
     */
    public function register(): void
    {
        // 🔑 Register the class as a singleton in the Service Container.
        $this->app->singleton(CurrencyConverter::class, function ($app) {
            // The closure is executed only the first time the class is resolved.
            return new CurrencyConverter(); 
        });

        // Optionally, register a shorter alias for the container
        $this->app->alias(CurrencyConverter::class, 'currency.converter');
    }

    // ... (boot method is not needed here)
}
?>

config/app.php

<?php 
// config/app.php

'providers' => ServiceProvider::defaultProviders()->merge([
    // ... other providers
    App\Providers\CurrencyConverterServiceProvider::class, // <-- Add this line
])->toArray(),

?>

in controller class -
<?php

namespace App\Http\Controllers;

use App\Services\CurrencyConverter; // 💡 Note: This is the class, not the getInstance() call

class ConversionController extends Controller
{
    protected $converter;

    // Laravel automatically injects the SINGLETON instance here
    public function __construct(CurrencyConverter $converter)
    {
        $this->converter = $converter;
    }

    public function showConversion()
    {
        $amount = 150.00;
        $converted = $this->converter->convert($amount, 'USD', 'EUR');
        
        // Every time this controller is instantiated, it gets the same object.
        return view('conversion', ['result' => $converted]); 
    }
}

?>



while initilization app Configration service provider load Configration files
include config/database.php -
Database Service Provider Registration is responsible for registering the necessary services
 into the Service Container it register database manager as sigleton like this
 $this->app->singleton('db', function ($app) {
    return new DatabaseManager($app, $app['db.factory']);
});

This ensures that every time the application requests the 'db' service, it receives the exact 
same instance of the DatabaseManager