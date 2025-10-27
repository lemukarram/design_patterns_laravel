The Builder Pattern is a creational design pattern that allows you to construct complex objects step-by-step. It separates the construction of a complex object from its representation and then allows the same construction process to create different representations.

the main goal of builder pattern is To solve the problem of having a "telescoping constructor" (a constructor with many optional arguments)
it helps to create an object that can be configured in many different ways.

the Key Components for builder pattern are
Product: The complex object that we want to build

Builder Interface: A contract that defines all the steps required to build the product.

Concrete Builder: The class that implements the Builder Interface. It holds an instance of the Product and implements the detailed steps to construct the product, often returning itself ($this) to allow method chaining.

Director (Optional): A class that knows the sequence of construction steps for common configurations

so The Builder Pattern is used for complex object construction via step-by-step, chained methods.

entire Eloquent Query Builder system is a real-world application of the Builder pattern.
