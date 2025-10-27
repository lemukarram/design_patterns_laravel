The Repository Pattern acts as a middle layer or a bridge between the business logic of your application and the data source (like a database)

the main goal of repository pattern is To decouple your application's logic from the specific database queries and ORM (Eloquent).

for impelimentation you need to create
Repository Interface: A contract that defines what methods the repository must have (e.g., getById(id), getAll(), create(data)). This ensures any class implementing it follows the rules.

Concrete Repository: The actual class that implements the interface and contains the specific Eloquent/database query code.

Service/Controller: The part of your application that calls the repository methods.

The Repository Pattern solves common development problems, mainly related to testing and flexibility.

Recap the main benefit: Decoupling the database layer from the business logic.
