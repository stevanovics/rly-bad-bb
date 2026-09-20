# Rly Bad BB

A really bad no dependencies Bulletin Board implementation in PHP.

---

## Tech Stack

* **PHP:** 8.5 (FPM, Alpine)
* **Web Server:** Nginx (Alpine)
* **Database:** MariaDB 12.3 LTS
* **Package Manager:** Composer (bundled in PHP container)

---

## Project Structure

```text
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   └── php/
│       └── Dockerfile
├── src/
│   ├── public/
│   │   └── index.php        # Application entry point (Front Controller)
│   ├── composer.json
│   └── composer.lock
├── .env.example             # Template for environment variables
├── docker-compose.yml       # Service orchestration
└── README.md
```
