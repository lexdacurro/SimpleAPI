
# PHP SimpleAPI

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![PHP](https://img.shields.io/badge/php-%3E%3D8.1-777bb4)

SimpleAPI is a modern, lightweight, and high-performance PHP framework for building APIs, heavily inspired by Python’s **FastAPI**.

It focuses on simplicity, developer productivity, and minimal boilerplate.

---

## Getting Started

Define routes using simple callback handlers:

    $app->get(PATTERN, function($params){
		  <YOUR CODE HERE>
    });

The callback automatically receives route parameters when available.
    
    $app->get('api/v1/{table_id}, function($params){
				// this returns [{table_id} => <VALUE_HERE>]
				print_r($params);
    });

### Key Features
SimpleAPI takes inspiration from FastAPI while keeping PHP development straightforward and efficient

-   **Easy to Learn** — Minimal setup and intuitive routing.
-   **Less Boilerplate** — Write less repetitive code.
-   **Fast Development** — Quickly build and ship API features.
-   **High Performance** — Lightweight routing and minimal overhead.
-   **Strict Typing Ready** — Built for PHP ≥ 8 with strong typing support.
-   **Clean Routing** — Laravel/FastAPI-style route parameters.
 

### Roadmap

Planned improvements:

-   Middleware support
-   Dependency injection
-   Request validation
-   Response helpers
-   Controller support
-   OpenAPI generation