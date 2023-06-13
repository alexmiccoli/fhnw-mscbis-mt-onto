

# Master's Thesis Data Repository

**Welcome to my Master's thesis data repository!**

This repository contains data and accompanying resources for my Master's thesis.

## Thesis Information

**Title**
A domain-specific visual approach to semantically describe shared datasets in business ecosystems

**University**
[University of Applied Sciences and Arts Northwestern Switzerland FHNW](https://www.fhnw.ch/en)

**Curriculum**
[Master of Science (MSc) in Business Information Systems (BIS) FHNW](https://www.fhnw.ch/en/degree-programmes/business/msc-bis)

**Date of Submission**
June 21st, 2023

**Author**
Alexandre Miccoli, 16-658-288

**Supervisor**
Dr. Emanuele Laurenzi 

## Contents by Folder


- `data`  : the raw and processed data used for the prototype
- `data/preprocessed` : converted spatial data to flat structures
- `data/sources` : raw data
- `data/Canton Lucerne` : source data from opendata.swisscom
- `data/Swisscom` : source data from the Swisscom Open Data platform
- `diagrams` : source files for graphics presented in the report
- `metaphactory_backup/*` : exports from Metaphactory to be re-imported if needed
- `ontologies` : the ontology repository from Metaphactory
- `scripts` : PHP files for data manipulations and SPARQL preparation

Please note that the files in `/metaphactory_backup` are not meant to be read outside Metaphactory but as a backup to be re-imported in Metaphactory if needed.
Do not edit files in the `/ontologies` folder of the Master branch directly. Instead create a new branch, then test if everything works in Metaphactory and then merge the branch to Master.

## Running PHP Scripts

To run the PHP scripts, you first need to import the data from `data/db.sql` as a MySQL database. Then, copy scripts/config.tpl.php to `scripts/config.php` and enter the needed information. Then, navigate to the needed script from your browser. Note: The contents of `scripts/` must be placed in a location accessible for your PHP engine.

## Contact

Reach out to me by e-mail at [alexandre.miccoli@students.fhnw.ch](mailto:alexandre.miccoli@students.fhnw.ch), using the contact details on [my GitHub Profile Page](https://github.com/alexmiccoli) or via [LinkedIn](https://www.linkedin.com/in/alexmiccoli).
