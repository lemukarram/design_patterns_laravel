A Facade provides a convenient, memorable, and static interface to the various services available in Laravel's Service Container.

the Simple Goal of facad is To let you access complex underlying class methods (like those on a Session or File service) using simple, static-like syntax, without having to manually inject the full class.

some commond examples of facad
Route::get(...)
DB::table(...)
Session::put(...)
Cache::get(...)

For Controller constructors and core Service classes, injecting dependencies is the best practice for testability. Use Facades primarily for convenient, quick access in routing files, Blade templates, or when testability is a lower concern
