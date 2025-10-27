The Adapter Pattern is a structural design pattern that allows two incompatible interfaces to work together. It acts as a wrapper or a bridge between two objects, translating the interface of one class into another interface the client expects.

Simple Goal: To make existing classes or services compatible with the rest of your application without modifying their source code.

Key Components
Client: The class that uses the existing interface and expects to communicate with it.

Target Interface: The interface the Client expects to work with (e.g., PaymentGatewayInterface).

Adaptee: The existing class that you want to integrate, but its interface is incompatible (e.g., OldThirdPartyPaypalApi).

Adapter: The class that implements the Target Interface and wraps the Adaptee. It translates the calls from the Client into the methods that the Adaptee uses.

Integration of Legacy/External Code
