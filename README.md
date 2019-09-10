# Symfony API

Hi! In this description, you'll encounter the explaining to run the API. Initially, you need to install the dependencies by using this command.

`composer install`

After the installation the libraries, create a file called `.env.local` into the root directory of the project, next to .env file. You can copy content from  `.env`file to `.env.local`file and type your `DATABASE_URL`. For example;

```yaml
APP_ENV=dev  
APP_SECRET=9e0bae166dd14503b04d5103dfbfae99  
#TRUSTED_PROXIES=127.0.0.1,127.0.0.2  
#TRUSTED_HOSTS='^localhost|example\.com$'  
###< symfony/framework-bundle ###  
  
DATABASE_URL=mysql://root:symf0ny@mysql:3306/my_db
```

# Endpoints

There are two endpoints such as `Edge` and `Node`, you can run HTTP Verbs on those endpoints. You can imagine the following.

http://localhost:8000/edges (GET,POST,PUT,DELETE)
http://localhost:8000/edges (GET,POST,PUT,DELETE)

```mermaid
graph LR
A((Node - 1)) -- Edge - 1 --> B((Node - 2))
B((Node - 2)) -- Edge - 2 --> C((Node - 3))
C((Node - 4)) -- Edge - 3 --> D((Node - 5))
```

### Node Requests ###
Node - POST sample;
http://localhost:8000/nodes (POST)
You need to request with this Array-JSON body;
[{"name":"node - 1"},{"name":"node - 2"}, {"name":"node - 3"},{"name":"node - 4"}]

Node - PUT sample;
http://localhost:8000/nodes (PUT)
You need to request with this Array-JSON body;
[{"name":"node - 9", "id":1},{"name":"node - 2", "id":3}]

Node - DELETE sample;
http://localhost:8000/nodes (DELETE)
You need to request with this Array body;
[9,3]

Node - GET sample;
http://localhost:8000/nodes (GET)


### Edge Requests ###

Edge - POST sample;
http://localhost:8000/edges (POST)
You need to request with this Array-JSON body;
[{"name":"my_edge", "node_id":10, "directed_node_id":11},{"name":"my_edge2", "node_id":12, "directed_node_id":13}]

Edge - PUT sample;
http://localhost:8000/edges (PUT)
You need to request with this Array-JSON body;
[{"id":7, "node_id":12, "directed_node_id":11}]

Edge - DELETE sample;
http://localhost:8000/edges (DELETE)
You need to request with this Array body;
[3,4]

Edge - GET sample;
http://localhost:8000/edges (GET)
