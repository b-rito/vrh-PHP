# View Request Headers

Vrh-php is a webpage of PHP that can be deployed in an Azure Web App, or web server with PHP. This allows you to quickly confirm what Request Headers are being received in the event you're going through a proxy, chaining web services, or applying rewrites to Client requests in a service.

## Quickstart on Azure Web App

- An Azure account with an active subscription. [Create an account for free](https://azure.microsoft.com/free/).
- [Git](https://git-scm.com/)
- [PHP](https://php.net/manual/install.php)
- [Azure CLI](/cli/azure/install-azure-cli) to run commands in any shell to create and configure Azure resources.

### Using Azure CLI

1. In a terminal window, run the following commands to clone the application to the local environment and navigate to the project root.

   ```bash
   git clone https://github.com/b-rito/vrh-PHP
   cd vrh-PHP
   ```

1. Using Azure CLI command `az webapp up`, to create or update your Azure Web App in a single step. This will deploy the code in your local folder from where the command is executed.

   ```azurecli
   az webapp up --runtime "PHP:8.2" --os-type=linux
   ```

   - Only specifying the `--runtime` and `--os-type` will leave other values to automatically generate
   - Options that are common to specify
     - `--name myFirstWebApp`
     - `--resource-group myResourceGroup`
     - `--location eastus2` (az account list-locations)
     - `--sku B1`
   - More information available on Azure CLI [az webapp up](https://learn.microsoft.com/en-us/cli/azure/webapp?view=azure-cli-latest#az-webapp-up)
