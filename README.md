# ProductSup - SpreadSheet App Details & Installation  Guide

Contents
========

* [Application & Code Architecture](#design-tools)
* [Docker Environment Setup](#installation)
* [Running the Application & Configuration Guide](#installation)
* [Testing Strategy & Coverage](#coding-task-details)

### NB
The Secret folder will be shared via email for security purposes and should be placed in the 
appropriate config directory. This folder contains two key files: secret.yaml, 
which stores each client remote  connection credentials, and a second file containing the 
Google authentication JSON used for API access

## Design Depth

##### Stack
* Language:Php:8+
* framework:Symfony:7.2.5
* Cache:Redis:

#### Code Quality
* PhpStan
* Php-CS-Fixer

##### Code Architecture
* Patten: Clean Code & Solid 
* framework: Hexagonal

##### DevOps
* Docker for containerization
* Docker compose for cluster Management

#### Testing Depth
* Unit testing
* Integration Testing

#### Future Improvement
* Implement a Remote Client Strategy Pattern to handle external service interactions.

* Define a Configuration File Strategy to allow flexible loading of configuration sources.

* Apply a Sheet Configuration Strategy to manage dynamic spreadsheet structure mappings.

* Create an abstract base class XmlToSheetHandler, designed for extension by specialized classes, enabling automation and scheduled processing.

* Migrate spreadsheet-related .env configurations to a centralized YAML configuration file, establishing a single source of truth for spreadsheet settings.

* Develop a Product Factory Registry to facilitate dynamic instantiation of product entities based on runtime context or configuration.

* Leverage Service Resolvers (e.g., tagged service locators or Symfony’s ServiceSubscriberInterface) to dynamically resolve service implementations when multiple services share the same interface.

* Ensure Code Passes PHPStan Checks.

## Hexagonal Architecture
This diagram illustrates how the layers in the application interact with each other, 
following the principles of Hexagonal Architecture to ensure separation of concerns and flexibility in adapting to different interfaces.

[View Diagram Here](https://github.com/NANAADDO/productsup-spreadsheet/blob/master/appservice/storage/designs/clean%20-code-Architecture.png)


## Service Process Flow
Each service in the architecture is designed following the <b>Single Responsibility Principle</b>. This means every service focuses on a specific
task or concern, which not only improves maintainability but also makes it straightforward to test each service independently.
By isolating responsibilities, we ensure clear boundaries between components, enabling modular development and easier debugging


<img src="https://github.com/NANAADDO/productsup-spreadsheet/blob/master/appservice/storage/designs/service-process-flow.png" alt="Description" style="align-content: center;"  height="500"/>

## Interface Segregation & Dependency Injection
This diagram illustrates the principle of Interface Segregation, where each service implements only the methods 
it requires. By using dependency injection, services remain loosely coupled, making the system more scalable, maintainable, and easier to extend.

[View Diagram Here]( https://github.com/NANAADDO/productsup-spreadsheet/blob/master/appservice/storage/designs/interfaace%20-segration-dependency-inversion.png)


## Liskov Substitution Principle
This diagram illustrates the implementation of the Liskov Substitution Principle, ensuring polymorphism 
by allowing derived classes to be used interchangeably with their base classes without affecting functionality.

[View Diagram Here](https://github.com/NANAADDO/productsup-spreadsheet/blob/master/appservice/storage/designs/Liskov%20Substitution.png)

## Application Setup

###  LOCAL ENVIRONMENT 
* Make sure you have docker and docker-compose installed on your local environment.
* All local Env. commands are executed on terminal


## Local Env Test
#### Step 1:

Clone code repository to your local environment

```shell
git clone https://github.com/NANAADDO/productsup-spreadsheet.git

```

#### Step 2:

Change directory into the clone repository folder

```shell
cd productsup-spreadsheet
```

#### Step 3:


This bash script build and start the docker containers

*Execute the shell script with the command below
```shell
 ./build-containers.sh
```
### Shell script  execute below commands

```shell
 #!/bin/bash

app_path=appservice
app_directory=/appservice/

echo "****************************"
echo "** Building Docker Images ***"
echo "****************************"


docker-compose  build  && docker-compose up -d

echo "** Creating .ENV File ***"
docker exec -t $app_path bash  -c  "${app_directory}; cp .env.example .env"
echo "** Running Composer Install ***"
docker exec -t $app_path bash  -c  "${app_directory}; composer install"
echo "** Installing Dependencies ***"


```

## Application Configuration Guide

#### GOOGLE SPREADSHEET CONFIG :
#### METHOD 1

I have  simplified the process for testing by avoiding the need to manually download 
the Google Spreadsheet authentication JSON. Instead, the system uses
a predefined default path for authentication and sheet writing.

#### STEP 1 
Open a new Google Spreadsheet in your browser and grant
[productsup-feed@serene-utility-457421-e5.iam.gserviceaccount.com](#) write access by adding it as an editor.

#### STEP 2
Copy the Sheet ID from the red highlighted portion of the URL below:

https://docs.google.com/spreadsheets/d/ <span style="background-color: red; color:red;">Copy SheetID</span>/edit?gid=0#gid=0

#### STEP 3
Paste the copied Sheet ID into your .env file using the variable name GOOGLE_SHEETS_ID.
It should look like this:

```shell
GOOGLE_SHEETS_ID=1CAav5TIRu9oH9vVNxZPkFYiLO81FAVbwAeQW4VMeg2M
 ```
#### STEP 4 
This configuration in the table below can be changed or left as default  
###### NB
The FILE_SOURCE cam be passed also as an argument in the console which overwrite the env variable 

| NAME                               | PURPOSE                                                | VALUE                                 |
|------------------------------------|--------------------------------------------------------|---------------------------------------|
| FILE_SOURCE                        | Specifies the source of the file (local/remote)        | local/remote                          |
| FILE_NAME                          | Name of the feed file                                  | coffee_feed.xml                       |
| FILE_PATH                          | Path where the feed is stored locally                  | storage/feeds/products                |
| CLIENT_NAME                        | Identifier for the client using the feed               | productsup                            |
| FILE_REMOTE_CONNECTION_TYPE        | Protocol used for remote connection                    |                                       |
| FILE_REMOTE_SECRET_YML_DIRECTORY   | Path to the YAML file containing remote secrets        | config/secret/productsup/secret.yaml  |
| USED_GOOGLE_ENV_CONFIG             | Enables/disables Google Sheet integration              |                                       |
| GOOGLE_SHEETS_ID                   | ID of the target Google Spreadsheet                    |                                       |
| GOOGLE_SHEETS_CREDENTIALS_PATH     | Path to the Google Sheets API credentials file         | config/secret/google/credentials.json |
| GOOGLE_SHEETS_TITLE                | Optional: Title for the Google Sheet                   |                                       |


## Run the docker command to Execute the Console CLI

```shell
 docker exec -it appservice php bin/console sync:xml-to-sheets

 ```

#### METHOD 2
At this stage, you can download your Google Sheets secret JSON file from the Google Cloud Console and 
dynamically generate the sheet using your own account. 

#### STEP 1
To obtain/download your Google Sheets API credentials (the credentials.json file), you can follow these official guides:
[ https://developers.google.com/sheets/api/quickstart]( https://developers.google.com/sheets/api/quickstart)

#### STEP 2
Place the JSON credentials file inside the config/secret directory at 
the root of your project. Then, reference its path in the .env 
file using the variable GOOGLE_SHEETS_CREDENTIALS_PATH.
It should look like this:
```shell
GOOGLE_SHEETS_CREDENTIALS_PATH=config/secret/your-file-name.json
 ```
#### STEP 3
You can paste a copied google Sheet ID into your .env file using the variable name GOOGLE_SHEETS_ID which will be used as default 
Alternatively, you can leave the variable blank to automatically generate a new Sheet ID at runtime.

### NB
* Newly generated Sheet IDs are temporarily cached to improve performance.
* Remote files are downloaded and stored locally to enable faster and repeated access

### Run the docker command to Execute the Console CLI
```shell
 docker exec -it appservice php bin/phpunit

 ```

### Testing Strategy & Coverage:
```shell

**Run the shell script with the following command

 docker exec -it appservices php bin/phpunit
 
 ```
Testing is structured to cover the following features, 
ranging from unit tests to full integration testing of the service and its process flow.

### Coverage

### ✅ Test Coverage

| Test Name                                                              | Description                                                              | Type   |
|-----------------------------------------------------------------------|--------------------------------------------------------------------------|--------|
| `testFetchThrowsNotFoundExceptionIfFileDoesNotExist`                  | Ensures an exception is thrown if the specified file is not found       | Unit   |
| `testFetchThrowsFileNotAccessibleExceptionIfFileIsNotReadable`        | Validates behavior when file is not readable                            | Unit   |
| `testFetchThrowsInvalidFileTypeExceptionIfFileTypeIsNotXML`           | Ensures only `.xml` files are processed                                 | Unit   |
| `testFetchReturnsFileContentsIfValidFile`                             | Confirms valid XML files are correctly read and returned                | Unit   |
| `testFetchReturnsXmlContent`                                          | Verifies valid remote XML fetch returns expected content                | Unit   |
| `testFetchThrowsUnauthorizedException`                                | Checks that unauthorized access triggers the correct exception          | Unit   |
| `testFetchThrowsNotFoundException`                                    | Verifies missing remote file triggers NotFoundException                 | Unit   |
| `testParseReturnsArrayFromValidXml`                                   | Validates correct XML parsing into an associative array                 | Unit   |
| `testProcessUsesProvidedSheetId`                                      | Ensures `GoogleSpreadSheet` writes data to existing sheet using ID      | Unit   |
| `testProcessCreatesNewSheetIfNotSheetIdProvided`                      | Verifies a new sheet is created when no ID is provided                  | Unit   |
| `testProcessWritesToSheet`                                            | Checks that data is written to Google Sheet with the correct ID         | Unit   |
| `testExecuteRunsSuccessfully`                                         | Confirms the full execution pipeline completes successfully             | Integration |



