The Singleton Pattern is a creational design pattern

the main goal of Singleton is To ensure that only one object of a
particular class exists throughout the entire execution of an application,
providing a single point of access to that instance.

A Singleton implementation involves three specific steps
that prevent from creating multiple objects of a singleton class.

Make the constructor private, it does not allow to create
object of this class by using new keyword from outside the class.

A Private Static Variable that Stores the single instance of the class
we usually named it $instance.

A Public Static Method getInstance, it is the only way to access the instance.
It checks if the instance not exists, it creates the object, and then returns
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
