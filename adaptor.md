

### 1\. What is the Adapter Pattern?

  * **Definition:** The **Adapter Pattern** is a structural design pattern that allows two incompatible interfaces to work together. It acts as a wrapper or a bridge between two objects, translating the interface of one class into another interface the client expects.
  * **Simple Goal:** To make existing classes or services compatible with the rest of your application without modifying their source code.
  * **Analogy:** Think of a **Travel Power Adapter**. You have a device (your client code) with a European plug (interface 1), but the wall socket is American (interface 2). You don't change your device or the wall; you use a physical adapter to translate the electrical connection.

-----

### 2\. Key Components

1.  **Client:** The class that uses the existing interface and expects to communicate with it.
2.  **Target Interface:** The interface the Client expects to work with (e.g., `PaymentGatewayInterface`).
3.  **Adaptee:** The existing class that you want to integrate, but its interface is incompatible (e.g., `OldThirdPartyPaypalApi`).
4.  **Adapter:** The class that implements the **Target Interface** and wraps the **Adaptee**. It translates the calls from the Client into the methods that the Adaptee uses.

-----

### 3\. When and Why to Use It (Use Cases)

The Adapter Pattern is commonly used when integrating third-party libraries, external services, or legacy code.

| Benefit | Explanation |
| :--- | :--- |
| **Integration of Legacy/External Code** 🔌 | This is the primary use case. If you have an existing third-party library that can't be modified, the adapter lets you use it seamlessly with your application's defined interfaces. |
| **Code Standardization** 🛠️ | It allows you to enforce a common interface across multiple similar but incompatible classes (e.g., having a single `processPayment()` method for PayPal, Stripe, and a local bank API). |
| **Decoupling** 🔗 | Your core application remains decoupled from the specific implementation details of the third-party service. If the third-party API changes, you only update the Adapter, not all the code that uses it. |

-----

### 4\. PHP/Laravel Code Example

This example shows how to make an old, non-standard **Log System** (the **Adaptee**) compatible with your application's new **Logger Interface** (the **Target**).

### Scenario

Your application has a new logging standard defined by `LoggerInterface`. You need to integrate an older, third-party log class (`LegacyLogWriter`) without modifying its code.

-----

### 1\. The Target Interface (The Standard)

This is the interface your application expects.

```php
// app/Contracts/LoggerInterface.php

namespace App\Contracts;

interface LoggerInterface
{
    // The standard method signature we want to use everywhere
    public function logMessage(string $level, string $message): void;
}
```

-----

### 2\. The Incompatible Adaptee (The Third-Party Service)

This is the existing class with non-standard method names that we cannot change.

```php
// app/Services/LegacyLogWriter.php (The Adaptee)

namespace App\Services;

class LegacyLogWriter
{
    // The Adaptee uses a single, combined method for logging
    public function writeToLog(string $logText): void
    {
        $dateTime = date('Y-m-d H:i:s');
        echo "[LEGACY LOG - $dateTime] $logText\n";
    }
}
```

-----

### 3\. The Adapter (The Translator)

The Adapter implements the **Target Interface** and holds an instance of the **Adaptee**, translating the method calls.

```php
// app/Adapters/LegacyLogAdapter.php

namespace App\Adapters;

use App\Contracts\LoggerInterface;
use App\Services\LegacyLogWriter; // The Adaptee

class LegacyLogAdapter implements LoggerInterface
{
    private LegacyLogWriter $adaptee;

    // The Adapter is initialized with the Adaptee object
    public function __construct(LegacyLogWriter $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    // This implements the TARGET INTERFACE method
    public function logMessage(string $level, string $message): void
    {
        // 🚨 TRANSLATION/ADAPTATION:
        // We combine the standard $level and $message into the single $logText
        // parameter that the LegacyLogWriter expects.
        
        $logText = strtoupper($level) . ": " . $message;
        
        // Call the Adaptee's non-standard method
        $this->adaptee->writeToLog($logText); 
    }
}
```

-----

### 4\. Using the Adapter (The Client)

The code that uses the logging service remains clean and only uses the standard interface.

```php
// app/Services/UserService.php (The Client)

use App\Contracts\LoggerInterface;
use App\Adapters\LegacyLogAdapter;
use App\Services\LegacyLogWriter;

class UserService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        // $logger could be the Adapter or any other class implementing LoggerInterface
        $this->logger = $logger;
    }

    public function registerUser(string $name): void
    {
        // ... registration logic ...

        // Client uses the STANDARD logMessage() method
        $this->logger->logMessage('info', "User '$name' registered successfully.");
    }
}

// --- Application Entry Point ---

// 1. Create the Adaptee
$legacyWriter = new LegacyLogWriter();

// 2. Wrap the Adaptee with the Adapter
$legacyLoggerAdapter = new LegacyLogAdapter($legacyWriter);

// 3. Inject the Adapter into the Client (UserService)
$userService = new UserService($legacyLoggerAdapter);

// 4. Run the code
$userService->registerUser("Alice");

// Output:
// [LEGACY LOG - 2025-10-23 06:05:52] INFO: User 'Alice' registered successfully.
```
-----

### 5\. Conclusion and Summary

  * Recap: The Adapter Pattern is a **wrapper** that helps reconcile incompatible interfaces.
  * The primary role is **interface conversion**, allowing your application code to remain consistent and ignorant of external API quirks.
  * Emphasize that this is structurally similar to how Laravel's **Filesystem** (Flysystem) or **Queue** implementations use adapters to treat local storage, S3, Redis, and Beanstalk as having a single, unified interface.
