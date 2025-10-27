The Observer Pattern is a behavioral design pattern that defines a one-to-many dependency between objects. When one object (the Subject or Publisher) changes its state, all its dependents (the Observers or Subscribers) are notified and updated automatically.

Simple Goal: To provide a mechanism for objects to communicate without tightly coupling them. The Subject doesn't need to know what the Observers do, only that they need to be notified.

Key Components
Subject/Publisher: The object that holds the state and notifies the observers when its state changes. It maintains a list of attached observers.

Observer/Subscriber: The object that wants to be notified of changes in the Subject. It must implement a specific method (e.g., update()) that the Subject will call.

Client: The code that creates the Subject and Observer objects and attaches the Observers to the Subject.

commond use cases
notifiation system
event handling
