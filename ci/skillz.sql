-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: skillz
-- ------------------------------------------------------
-- Server version	10.3.22-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20200518080328','2020-05-18 08:03:44'),('20200518121413','2020-05-18 12:14:22'),('20200518130928','2020-05-18 13:09:37');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Skill Matrix is filled in self-assessment guided by the following statements. In this area…','<ul>\r\n<li>\r\n5: I am confident that I can work out various solution concepts, as well as defend and implement them professionally\r\n</li>\r\n<li>\r\n4: I am confident in the comprehensive solution conception of very complex requirements and their implementation\r\n</li>\r\n<li>\r\n3: I am confident in the implementation of complex technical solutions\r\n</li><li>\r\n2: I have fundamental experience in this area. \r\n</li><li>\r\n1: I am completely inexperienced in this area.\r\n</li><li>\r\n* added: I want to gain more knowledge in this area.\r\n</li></ul>');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `learn` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_136AC1131E27F6BF` (`question_id`),
  KEY `FK_136AC1135585C142` (`skill_id`),
  KEY `FK_136AC113A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `result`
--

LOCK TABLES `result` WRITE;
/*!40000 ALTER TABLE `result` DISABLE KEYS */;
INSERT INTO `result` VALUES (1,1,1,1,3,0),(2,1,14,1,5,0),(3,1,18,1,0,0),(4,1,3,1,5,0),(5,1,16,1,6,0),(6,1,17,1,4,0),(7,1,15,1,6,0),(8,1,5,1,4,0),(9,1,19,1,2,0),(10,1,4,1,4,0),(11,1,6,1,4,0),(12,1,15,2,3,0),(13,1,4,2,1,0),(14,1,16,2,4,0),(15,1,14,2,5,0),(16,1,17,2,1,0),(17,1,5,2,6,0),(18,1,3,2,3,0),(19,1,20,1,6,0),(20,1,15,10,5,0),(21,1,35,10,4,0),(22,1,37,10,3,0),(23,1,39,10,6,0),(24,1,40,10,5,0),(25,1,36,10,3,0),(26,1,27,10,3,0),(27,1,28,10,3,0),(28,1,29,10,3,0),(29,1,32,10,4,0),(30,1,30,10,3,0),(31,1,31,10,3,0),(32,1,22,1,5,0),(33,1,35,1,4,0),(34,1,36,1,6,0),(35,1,39,1,5,0),(36,1,3,7,3,1),(37,1,14,7,2,0),(38,1,39,7,3,0),(39,1,37,7,0,0),(40,1,40,7,1,0),(41,1,6,7,1,0),(42,1,26,7,1,0),(43,1,23,7,0,0),(44,1,52,10,5,0),(45,1,47,10,3,0),(46,1,22,10,4,0),(47,1,44,10,4,0),(48,1,38,10,1,0),(49,1,3,4,2,1),(50,1,4,4,1,0),(51,1,5,4,1,0),(52,1,6,4,1,0),(53,1,41,4,3,0),(54,1,46,4,5,0),(55,1,42,4,5,0),(56,1,47,4,1,1),(57,1,48,4,6,0),(58,1,49,4,4,1),(59,1,51,4,1,0),(60,1,14,4,2,1),(61,1,27,4,2,0),(62,1,28,4,2,0),(63,1,29,4,2,0),(64,1,30,4,1,0),(65,1,31,4,2,0),(66,1,32,4,1,0),(67,1,33,4,1,0),(68,1,20,4,1,0),(69,1,40,4,2,0),(70,1,39,4,2,0),(71,1,37,4,1,0),(72,1,21,4,1,0),(73,1,38,4,1,0),(74,1,50,4,1,0),(75,1,43,4,2,1),(76,1,44,4,3,0),(77,1,45,4,3,0),(78,1,22,4,1,0),(79,1,23,4,1,0),(80,1,24,4,1,0),(81,1,25,4,1,0),(82,1,26,4,1,0),(83,1,52,4,2,0),(84,1,53,4,1,0),(85,1,54,4,1,0),(86,1,55,4,1,0),(87,1,56,4,1,0),(88,1,35,13,2,0),(89,1,20,13,6,0),(90,1,4,13,6,0),(91,1,36,13,4,0),(92,1,34,13,0,0),(93,1,38,13,4,0),(94,1,50,13,3,0),(95,1,3,13,4,0),(96,1,15,13,5,0),(97,1,16,13,5,0),(98,1,17,13,3,0),(99,1,18,13,0,0),(100,1,19,13,3,0),(101,1,37,13,5,0),(102,1,14,13,6,0),(103,1,39,13,5,0),(104,1,40,13,5,0),(105,1,27,13,6,0),(106,1,28,13,6,0),(107,1,5,13,5,0),(108,1,29,13,5,0),(109,1,30,13,1,0),(110,1,31,13,5,0),(111,1,32,13,0,0),(112,1,33,13,3,0),(113,1,22,13,6,0),(114,1,23,13,6,0),(115,1,24,13,6,0),(116,1,25,13,5,0),(117,1,26,13,5,0),(118,1,6,13,5,0),(119,1,43,13,5,0),(120,1,42,13,6,0),(121,1,44,13,4,0),(122,1,45,13,0,0),(123,1,41,13,4,0),(124,1,47,13,5,1),(125,1,48,13,4,0),(126,1,49,13,3,0),(127,1,46,13,4,0),(128,1,52,13,5,0),(129,1,53,13,4,0),(130,1,54,13,5,0),(131,1,55,13,4,0),(132,1,56,13,5,0),(133,1,51,13,5,0),(134,1,1,13,4,0);
/*!40000 ALTER TABLE `result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill`
--

DROP TABLE IF EXISTS `skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `path` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill`
--

LOCK TABLES `skill` WRITE;
/*!40000 ALTER TABLE `skill` DISABLE KEYS */;
INSERT INTO `skill` VALUES (1,'Tech','A web developer is a programmer who specializes in, or is specifically engaged in, the development of World Wide Web applications using a client–server model. The applications typically use HTML, CSS and JavaScript in the client, PHP, ASP.NET or Java in the server, and http for communications between client and server. A web content management system is often used to develop and maintain web applications.',0,1,'|0|'),(3,'Frontend','Front-end web development is the practice of converting data to a graphical interface, through the use of HTML, CSS, and JavaScript, so that users can view and interact with that data.',1,1,'|0|1|'),(4,'Backend','In software architecture, there may be many layers between the hardware and end user. The front is an abstraction, simplifying the underlying component by providing a user-friendly interface, while the back usually handles data storage and business logic.\r\n\r\nIn telecommunication, the front can be considered a device or service, while the back is the infrastructure that supports provision of service.\r\n\r\nA rule of thumb is that the client-side (or \"front end\") is any component manipulated by the user. The server-side (or \"back end\") code usually resides on the server, often far removed physically from the user.',1,1,'|0|1|'),(5,'DevOps','Academics and practitioners have not developed a unique definition for the term \"DevOps.\"\r\nFrom an academic perspective, Len Bass, Ingo Weber, and Liming Zhu — three computer science researchers from the CSIRO and the Software Engineering Institute — suggested defining DevOps as \"a set of practices intended to reduce the time between committing a change to a system and the change being placed into normal production, while ensuring high quality\".[6]\r\n\r\nThe term DevOps, however, has been used in multiple contexts.',1,1,'|0|1|'),(6,'Architect','Software architecture refers to the fundamental structures of a software system and the discipline of creating such structures and systems. Each structure comprises software elements, relations among them, and properties of both elements and relations.[1] The architecture of a software system is a metaphor, analogous to the architecture of a building.[2] It functions as a blueprint for the system and the developing project, laying out the tasks necessary to be executed by the design teams.[3]',1,1,'|0|1|'),(14,'Javascript','JavaScript, often abbreviated as JS, is a programming language that conforms to the ECMAScript specification. JavaScript is high-level, often just-in-time compiled, and multi-paradigm. It has curly-bracket syntax, dynamic typing, prototype-based object-orientation, and first-class functions.',3,1,'|0|1|3|'),(15,'jQuery',NULL,14,1,'|0|1|3|14|'),(16,'VueJs',NULL,14,1,'|0|1|3|14|'),(17,'ReactJs',NULL,14,1,'|0|1|3|14|'),(18,'Backbone JS',NULL,14,1,'|0|1|3|14|'),(19,'Webpack',NULL,14,1,'|0|1|3|14|'),(20,'PHP','PHP is a popular general-purpose scripting language that is especially suited to web development. It was originally created by Rasmus Lerdorf in 1994; the PHP reference implementation is now produced by The PHP Group. PHP originally stood for Personal Home Page, but it now stands for the recursive initialism PHP: Hypertext Preprocessor.Wikipedia',4,1,'|0|1|4|'),(21,'Java','Programming Language\r\noracle.com/java\r\nJava is a general-purpose programming language that is class-based, object-oriented, and designed to have as few implementation dependencies as possible. It is intended to let application developers write once, run anywhere, meaning that compiled Java code can run on all platforms that support Java without the need for recompilation.Wikipedia',4,1,'|0|1|4|'),(22,'OOP','Object-oriented programming is a programming paradigm based on the concept of \"objects\", which can contain data, in the form of fields, and code, in the form of procedures. A feature of objects is an object\'s procedures that can access and often modify the data fields of the object with which they are associated.Wikipedia',6,1,'|0|1|5|'),(23,'Funktional','Functional languages are good when you have a fixed set of things, and as your code evolves, you primarily add new operations on existing things. This can be accomplished by adding new functions which compute with existing data types, and the existing functions are left alone.',6,1,'|0|1|5|'),(24,'Clean Code','Robert Cecil Martin, popularly known as \"Uncle Bob\", is an American software engineer and instructor. He is best known for being one of the authors of the Agile Manifesto and for developing several software design principles. He was also the editor-in-chief of C++ Report magazine and served as the first chairman of the Agile Alliance.Wikipedia',6,1,'|0|1|5|'),(25,'Design Patterns','Design Patterns: Elements of Reusable Object-Oriented Software is a software engineering book describing software design patterns. The book was written by Erich Gamma, Richard Helm, Ralph Johnson, and John Vlissides, with a foreword by Grady Booch.Wikipedia',6,1,'|0|1|5|'),(26,'UML','Unified Modeling Language\r\nThe Unified Modeling Language is a general-purpose, developmental, modeling language in the field of software engineering that is intended to provide a standard way to visualize the design of a system. The creation of UML was originally motivated by the desire to standardize the disparate notational systems and approaches to software design.Wikipedia',6,1,'|0|1|5|'),(27,'bash',NULL,5,1,'|0|1|5|'),(28,'Git',NULL,5,1,'|0|1|5|'),(29,'CI/CD','Deployment automatisation',5,1,'|0|1|5|'),(30,'Cloud (AWS, Azure etc.)',NULL,5,1,'|0|1|5|'),(31,'Docker',NULL,5,1,'|0|1|5|'),(32,'Vagrant',NULL,5,1,'|0|1|5|'),(33,'Infrastruktur Design',NULL,5,1,'|0|1|5|'),(34,'Spring','The Spring Framework is an application framework and inversion of control container for the Java platform. The framework\'s core features can be used by any Java application, but there are extensions for building web applications on top of the Java EE platform.Wikipedia',21,1,'|0|1|4|21|'),(35,'Laravel','Laravel is a free, open-source PHP web framework, created by Taylor Otwell and intended for the development of web applications following the model–view–controller architectural pattern and based on Symfony.Wikipedia',20,1,'|0|1|4|20|'),(36,'Symphony','Symfony is a PHP web application framework and a set of reusable PHP components/libraries. It was published as free software on October 18, 2005 and released under the MIT license.Wikipedia',20,1,'|0|1|4|20|'),(37,'TypeScript','TypeScript is an open-source programming language developed and maintained by Microsoft. It is a strict syntactical superset of JavaScript and adds optional static typing to the language. TypeScript is designed for development of large applications and transcompiles to JavaScript.Wikipedia',3,1,'|0|1|3|'),(38,'Python','Python is an interpreted, high-level, general-purpose programming language. Created by Guido van Rossum and first released in 1991, Python\'s design philosophy emphasizes code readability with its notable use of significant whitespace.Wikipedia',4,1,'|0|1|4|'),(39,'html','Hypertext Markup Language is the standard markup language for documents designed to be displayed in a web browser. It can be assisted by technologies such as Cascading Style Sheets and scripting languages such as JavaScript. Web browsers receive HTML documents from a web server or from local storage and render the documents into multimedia web pages.Wikipedia',3,1,'|0|1|3|'),(40,'css, scss, less','Cascading Style Sheets is a style sheet language used for describing the presentation of a document written in a markup language like HTML. CSS is a cornerstone technology of the World Wide Web, alongside HTML and JavaScript. CSS is designed to enable the separation of presentation and content, including layout, colors, and fonts.Wikipedia',3,1,'|0|1|3|'),(41,'Softwareproducts','Computer software, or simply software, is a collection of data or computer instructions that tell the computer how to work. This is in contrast to physical hardware, from which the system is built and actually performs the work.Wikipedia',1,1,'|0|1|'),(42,'Shopware 5','Shopware ist ein seit 2004 in Deutschland entwickeltes, modulares Online-Shopsystem. Es steht sowohl als Open-Source-Software wie auch in kommerziellen Editionen zur Verfügung. Bis Shopware 5 handelt es sich um ein reines Shopsystem mit CMS-Funktionalitäten, welches durch mehrere Tausend Erweiterungen auf die Bedürfnisse des Nutzers anpassbar ist.Wikipedia (DE)',41,1,'|0|1|41|'),(43,'Shopware 6',NULL,41,1,'|0|1|41|'),(44,'Spryker',NULL,41,1,'|0|1|41|'),(45,'Commercetools',NULL,41,1,'|0|1|41|'),(46,'Testing','stakeholders with information about the quality of the software product or service under test. Software testing can also provide an objective, independent view of the software to allow the business to appreciate and understand the risks of software implementation.Wikipedia',1,1,'|0|1|'),(47,'Unit/Int/Func Tests',NULL,46,1,'|0|1|46|'),(48,'Manual Testing',NULL,46,1,'|0|1|46|'),(49,'E2E Tests',NULL,46,1,'|0|1|46|'),(50,'Go','Go is a statically typed, compiled programming language designed at Google[14] by Robert Griesemer, Rob Pike, and Ken Thompson.[12] Go is syntactically similar to C, but with memory safety, garbage collection, structural typing,[6] and CSP-style concurrency.[15] The language is often referred to as \"Golang\" because of its domain name, golang.org, but the proper name is Go.[16]',4,1,'|0|1|4|'),(51,'Databases','A database is an organized collection of data, generally stored and accessed electronically from a computer system. Where databases are more complex they are often developed using formal design and modeling techniques.Wikipedia',1,1,'|0|1|'),(52,'MySQL / Maria / Percona','MySQL is an open-source relational database management system. Its name is a combination of \"My\", the name of co-founder Michael Widenius\'s daughter, and \"SQL\", the abbreviation for Structured Query Language. MySQL is free and open-source software under the terms of the GNU General Public License, and is also available under a variety of proprietary licenses.Wikipedia',51,1,'|0|1|51|'),(53,'Postgres','PostgreSQL, also known as Postgres, is a free and open-source relational database management system emphasizing extensibility and SQL compliance. It was originally named POSTGRES, referring to its origins as a successor to the Ingres database developed at the University of California, Berkeley.Wikipedia',51,1,'|0|1|51|'),(54,'MongoDB','MongoDB is a cross-platform document-oriented database program. Classified as a NoSQL database program, MongoDB uses JSON-like documents with optional schemas. MongoDB is developed by MongoDB Inc. and licensed under the Server Side Public License.Wikipedia',51,1,'|0|1|51|'),(55,'ElasticSearch','Elasticsearch is a search engine based on the Lucene library. It provides a distributed, multitenant-capable full-text search engine with an HTTP web interface and schema-free JSON documents. Elasticsearch is developed in Java.Wikipedia',51,1,'|0|1|51|'),(56,'Redis','Redis (/ˈrɛdɪs/;[6][7] Remote Dictionary Server)[6] is an in-memory data structure project implementing a distributed, in-memory key-value database with optional durability. Redis supports different kinds of abstract data structures, such as strings, lists, maps, sets, sorted sets, HyperLogLogs, bitmaps, streams, and spatial indexes. The project is mainly developed by Salvatore Sanfilippo and as of 2019, is sponsored by Redis Labs.[8] It is open-source software released under a BSD 3-clause license.[5]',51,1,'|0|1|51|');
/*!40000 ALTER TABLE `skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill_result_index`
--

DROP TABLE IF EXISTS `skill_result_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skill_result_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL,
  `average` float NOT NULL,
  `children_average` float NOT NULL,
  `children_highest` int(11) NOT NULL,
  `max_result` int(11) DEFAULT NULL,
  `skill_name` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill_parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill_result_index`
--

LOCK TABLES `skill_result_index` WRITE;
/*!40000 ALTER TABLE `skill_result_index` DISABLE KEYS */;
INSERT INTO `skill_result_index` VALUES (1,1,3.5,3.3913,6,4,'Tech',0),(2,3,3.4,3.5,6,5,'Frontend',1),(3,4,3,2.6667,6,6,'Backend',1),(4,5,4,2.8,6,6,'DevOps',1),(5,6,2.75,3.0714,6,5,'Architect',1),(6,14,4,3.3571,6,6,'Javascript',3),(7,15,4.75,0,0,6,'jQuery',14),(8,16,5,0,0,6,'VueJs',14),(9,17,2.6667,0,0,4,'ReactJs',14),(10,18,0,0,0,0,'Backbone JS',14),(11,19,2.5,0,0,3,'Webpack',14),(12,20,4.3333,3.8333,6,6,'PHP',4),(13,21,1,0,0,1,'Java',4),(14,22,4,0,0,6,'OOP',6),(15,23,2.3333,0,0,6,'Funktional',6),(16,24,3.5,0,0,6,'Clean Code',6),(17,25,3,0,0,5,'Design Patterns',6),(18,26,2.3333,0,0,5,'UML',6),(19,27,3.6667,0,0,6,'bash',5),(20,28,3.6667,0,0,6,'Git',5),(21,29,3.3333,0,0,5,'CI/CD',5),(22,30,1.6667,0,0,3,'Cloud (AWS, Azure etc.)',5),(23,31,3.3333,0,0,5,'Docker',5),(24,32,1.6667,0,0,4,'Vagrant',5),(25,33,2,0,0,3,'Infrastruktur Design',5),(26,34,0,0,0,0,'Spring',21),(27,35,3.3333,0,0,4,'Laravel',20),(28,36,4.3333,0,0,6,'Symphony',20),(29,37,2.25,0,0,5,'TypeScript',3),(30,38,2,0,0,4,'Python',4),(31,39,4.2,0,0,6,'html',3),(32,40,3.25,0,0,5,'css, scss, less',3),(33,41,3.5,3.5556,6,4,'Softwareproducts',1),(34,42,5.5,0,0,6,'Shopware 5',41),(35,43,3.5,0,0,5,'Shopware 6',41),(36,44,3.6667,0,0,4,'Spryker',41),(37,45,1.5,0,0,3,'Commercetools',41),(38,46,4.5,3.7143,6,5,'Testing',1),(39,47,3,0,0,5,'Unit/Int/Func Tests',46),(40,48,5,0,0,6,'Manual Testing',46),(41,49,3.5,0,0,4,'E2E Tests',46),(42,50,2,0,0,3,'Go',4),(43,51,3,3.0909,5,5,'Databases',1),(44,52,4,0,0,5,'MySQL / Maria / Percona',51),(45,53,2.5,0,0,4,'Postgres',51),(46,54,3,0,0,5,'MongoDB',51),(47,55,2.5,0,0,4,'ElasticSearch',51),(48,56,3,0,0,5,'Redis',51);
/*!40000 ALTER TABLE `skill_result_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill_result_index_user`
--

DROP TABLE IF EXISTS `skill_result_index_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skill_result_index_user` (
  `skill_result_index_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`skill_result_index_id`,`user_id`),
  KEY `IDX_1B726CDD15F71E17` (`skill_result_index_id`),
  KEY `IDX_1B726CDDA76ED395` (`user_id`),
  CONSTRAINT `FK_1B726CDD15F71E17` FOREIGN KEY (`skill_result_index_id`) REFERENCES `skill_result_index` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill_result_index_user`
--

LOCK TABLES `skill_result_index_user` WRITE;
/*!40000 ALTER TABLE `skill_result_index_user` DISABLE KEYS */;
INSERT INTO `skill_result_index_user` VALUES (1,1),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(2,1),(2,4),(2,5),(2,6),(2,7),(2,8),(2,9),(2,10),(2,11),(2,12),(2,13),(3,1),(3,4),(3,5),(3,6),(3,7),(3,8),(3,9),(3,10),(3,11),(3,12),(3,13),(4,1),(4,4),(4,5),(4,6),(4,7),(4,8),(4,9),(4,10),(4,11),(4,12),(4,13),(5,1),(5,4),(5,5),(5,6),(5,7),(5,8),(5,9),(5,10),(5,11),(5,12),(5,13),(6,1),(6,4),(6,5),(6,6),(6,7),(6,8),(6,9),(6,10),(6,11),(6,12),(6,13),(7,1),(7,4),(7,5),(7,6),(7,7),(7,8),(7,9),(7,10),(7,11),(7,12),(7,13),(8,1),(8,4),(8,5),(8,6),(8,7),(8,8),(8,9),(8,10),(8,11),(8,12),(8,13),(9,1),(9,4),(9,5),(9,6),(9,7),(9,8),(9,9),(9,10),(9,11),(9,12),(9,13),(10,1),(10,4),(10,5),(10,6),(10,7),(10,8),(10,9),(10,10),(10,11),(10,12),(10,13),(11,1),(11,4),(11,5),(11,6),(11,7),(11,8),(11,9),(11,10),(11,11),(11,12),(11,13),(12,1),(12,4),(12,5),(12,6),(12,7),(12,8),(12,9),(12,10),(12,11),(12,12),(12,13),(13,1),(13,4),(13,5),(13,6),(13,7),(13,8),(13,9),(13,10),(13,11),(13,12),(13,13),(14,1),(14,4),(14,5),(14,6),(14,7),(14,8),(14,9),(14,10),(14,11),(14,12),(14,13),(15,1),(15,4),(15,5),(15,6),(15,7),(15,8),(15,9),(15,10),(15,11),(15,12),(15,13),(16,1),(16,4),(16,5),(16,6),(16,7),(16,8),(16,9),(16,10),(16,11),(16,12),(16,13),(17,1),(17,4),(17,5),(17,6),(17,7),(17,8),(17,9),(17,10),(17,11),(17,12),(17,13),(18,1),(18,4),(18,5),(18,6),(18,7),(18,8),(18,9),(18,10),(18,11),(18,12),(18,13),(19,1),(19,4),(19,5),(19,6),(19,7),(19,8),(19,9),(19,10),(19,11),(19,12),(19,13),(20,1),(20,4),(20,5),(20,6),(20,7),(20,8),(20,9),(20,10),(20,11),(20,12),(20,13),(21,1),(21,4),(21,5),(21,6),(21,7),(21,8),(21,9),(21,10),(21,11),(21,12),(21,13),(22,1),(22,4),(22,5),(22,6),(22,7),(22,8),(22,9),(22,10),(22,11),(22,12),(22,13),(23,1),(23,4),(23,5),(23,6),(23,7),(23,8),(23,9),(23,10),(23,11),(23,12),(23,13),(24,1),(24,4),(24,5),(24,6),(24,7),(24,8),(24,9),(24,10),(24,11),(24,12),(24,13),(25,1),(25,4),(25,5),(25,6),(25,7),(25,8),(25,9),(25,10),(25,11),(25,12),(25,13),(26,1),(26,4),(26,5),(26,6),(26,7),(26,8),(26,9),(26,10),(26,11),(26,12),(26,13),(27,1),(27,4),(27,5),(27,6),(27,7),(27,8),(27,9),(27,10),(27,11),(27,12),(27,13),(28,1),(28,4),(28,5),(28,6),(28,7),(28,8),(28,9),(28,10),(28,11),(28,12),(28,13),(29,1),(29,4),(29,5),(29,6),(29,7),(29,8),(29,9),(29,10),(29,11),(29,12),(29,13),(30,1),(30,4),(30,5),(30,6),(30,7),(30,8),(30,9),(30,10),(30,11),(30,12),(30,13),(31,1),(31,4),(31,5),(31,6),(31,7),(31,8),(31,9),(31,10),(31,11),(31,12),(31,13),(32,1),(32,4),(32,5),(32,6),(32,7),(32,8),(32,9),(32,10),(32,11),(32,12),(32,13),(33,1),(33,4),(33,5),(33,6),(33,7),(33,8),(33,9),(33,10),(33,11),(33,12),(33,13),(34,1),(34,4),(34,5),(34,6),(34,7),(34,8),(34,9),(34,10),(34,11),(34,12),(34,13),(35,1),(35,4),(35,5),(35,6),(35,7),(35,8),(35,9),(35,10),(35,11),(35,12),(35,13),(36,1),(36,4),(36,5),(36,6),(36,7),(36,8),(36,9),(36,10),(36,11),(36,12),(36,13),(37,1),(37,4),(37,5),(37,6),(37,7),(37,8),(37,9),(37,10),(37,11),(37,12),(37,13),(38,1),(38,4),(38,5),(38,6),(38,7),(38,8),(38,9),(38,10),(38,11),(38,12),(38,13),(39,1),(39,4),(39,5),(39,6),(39,7),(39,8),(39,9),(39,10),(39,11),(39,12),(39,13),(40,1),(40,4),(40,5),(40,6),(40,7),(40,8),(40,9),(40,10),(40,11),(40,12),(40,13),(41,1),(41,4),(41,5),(41,6),(41,7),(41,8),(41,9),(41,10),(41,11),(41,12),(41,13),(42,1),(42,4),(42,5),(42,6),(42,7),(42,8),(42,9),(42,10),(42,11),(42,12),(42,13),(43,1),(43,4),(43,5),(43,6),(43,7),(43,8),(43,9),(43,10),(43,11),(43,12),(43,13),(44,1),(44,4),(44,5),(44,6),(44,7),(44,8),(44,9),(44,10),(44,11),(44,12),(44,13),(45,1),(45,4),(45,5),(45,6),(45,7),(45,8),(45,9),(45,10),(45,11),(45,12),(45,13),(46,1),(46,4),(46,5),(46,6),(46,7),(46,8),(46,9),(46,10),(46,11),(46,12),(46,13),(47,1),(47,4),(47,5),(47,6),(47,7),(47,8),(47,9),(47,10),(47,11),(47,12),(47,13),(48,1),(48,4),(48,5),(48,6),(48,7),(48,8),(48,9),(48,10),(48,11),(48,12),(48,13);
/*!40000 ALTER TABLE `skill_result_index_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `root_skill_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D6492ED8ABA4` (`root_skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'benjamin.schnoor@etribes.de','[\"ROLE_USER\", \"ROLE_CONTENT\", \"ROLE_ADMIN\"]','google-oauth2|117666081476064189230',1),(4,'marcel.sander@etribes.de','[\"ROLE_USER\", \"ROLE_CONTENT\", \"ROLE_ADMIN\"]','google-oauth2|102825969487413549734',1),(5,'hannes.finck@etribes.de','[\"ROLE_USER\", \"ROLE_CONTENT\", \"ROLE_ADMIN\"]','google-oauth2|107810259611151108565',1),(6,'emilija.janakievska@etribes.de','[\"ROLE_USER\", \"ROLE_CONTENT\", \"ROLE_ADMIN\"]','google-oauth2|100728344225056318692',1),(7,'stefan.berkenhoff@etribes.de','[\"ROLE_USER\", \"ROLE_CONTENT\", \"ROLE_ADMIN\"]','google-oauth2|116040784763536952400',1),(8,'pablo.aubele@etribes.de','[\"ROLE_USER\",\"ROLE_CONTENT\",\"ROLE_ADMIN\"]','google-oauth2|103733888015935067311',1),(9,'ann-kristin.casper@etribes.de','[\"ROLE_USER\",\"ROLE_CONTENT\",\"ROLE_ADMIN\"]','google-oauth2|104538163247010474877',1),(10,'yubraj.ghimire@etribes.de','[]','google-oauth2|110975786704788769105',1),(11,'korkut.kaptanoglu@etribes.de','[]','google-oauth2|102927097960140011339',1),(12,'daniel.hawaliz@etribes.de','[]','google-oauth2|101327470752928256906',1),(13,'yannik.schwieger@etribes.de','[]','google-oauth2|112473055539607940867',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_result_index`
--

DROP TABLE IF EXISTS `user_result_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_result_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `children_average` float DEFAULT NULL,
  `children_highest` int(11) DEFAULT NULL,
  `skill_name` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill_parent_id` int(11) DEFAULT NULL,
  `email` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_914B4C8FA76ED395` (`user_id`),
  KEY `IDX_914B4C8F5585C142` (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_result_index`
--

LOCK TABLES `user_result_index` WRITE;
/*!40000 ALTER TABLE `user_result_index` DISABLE KEYS */;
INSERT INTO `user_result_index` VALUES (1,1,1,3,4.25,5,'Tech',0,'benjamin.schnoor@etribes.de'),(2,1,14,5,3.6,6,'Javascript',3,'benjamin.schnoor@etribes.de'),(3,1,18,0,0,0,'Backbone JS',14,'benjamin.schnoor@etribes.de'),(4,1,3,5,5,5,'Frontend',1,'benjamin.schnoor@etribes.de'),(5,1,16,6,0,0,'VueJs',14,'benjamin.schnoor@etribes.de'),(6,1,17,4,0,0,'ReactJs',14,'benjamin.schnoor@etribes.de'),(7,1,15,6,0,0,'jQuery',14,'benjamin.schnoor@etribes.de'),(8,1,5,4,0,0,'DevOps',1,'benjamin.schnoor@etribes.de'),(9,1,19,2,0,0,'Webpack',14,'benjamin.schnoor@etribes.de'),(10,1,4,4,6,6,'Backend',1,'benjamin.schnoor@etribes.de'),(11,1,6,4,5,5,'Architect',1,'benjamin.schnoor@etribes.de'),(12,1,20,6,5,6,'PHP',4,'benjamin.schnoor@etribes.de'),(13,1,22,5,0,0,'OOP',6,'benjamin.schnoor@etribes.de'),(14,1,35,4,0,0,'Laravel',20,'benjamin.schnoor@etribes.de'),(15,1,36,6,0,0,'Symphony',20,'benjamin.schnoor@etribes.de'),(16,1,39,5,0,0,'html',3,'benjamin.schnoor@etribes.de'),(17,4,3,2,1.75,2,'Frontend',1,'marcel.sander@etribes.de'),(18,4,4,1,1,1,'Backend',1,'marcel.sander@etribes.de'),(19,4,5,1,1.5714,2,'DevOps',1,'marcel.sander@etribes.de'),(20,4,6,1,1,1,'Architect',1,'marcel.sander@etribes.de'),(21,4,41,3,3.25,5,'Softwareproducts',1,'marcel.sander@etribes.de'),(22,4,46,5,3.6667,6,'Testing',1,'marcel.sander@etribes.de'),(23,4,42,5,0,0,'Shopware 5',41,'marcel.sander@etribes.de'),(24,4,47,1,0,0,'Unit/Int/Func Tests',46,'marcel.sander@etribes.de'),(25,4,48,6,0,0,'Manual Testing',46,'marcel.sander@etribes.de'),(26,4,49,4,0,0,'E2E Tests',46,'marcel.sander@etribes.de'),(27,4,51,1,1.2,2,'Databases',1,'marcel.sander@etribes.de'),(28,4,14,2,0,0,'Javascript',3,'marcel.sander@etribes.de'),(29,4,27,2,0,0,'bash',5,'marcel.sander@etribes.de'),(30,4,28,2,0,0,'Git',5,'marcel.sander@etribes.de'),(31,4,29,2,0,0,'CI/CD',5,'marcel.sander@etribes.de'),(32,4,30,1,0,0,'Cloud (AWS, Azure etc.)',5,'marcel.sander@etribes.de'),(33,4,31,2,0,0,'Docker',5,'marcel.sander@etribes.de'),(34,4,32,1,0,0,'Vagrant',5,'marcel.sander@etribes.de'),(35,4,33,1,0,0,'Infrastruktur Design',5,'marcel.sander@etribes.de'),(36,4,20,1,0,0,'PHP',4,'marcel.sander@etribes.de'),(37,4,40,2,0,0,'css, scss, less',3,'marcel.sander@etribes.de'),(38,4,39,2,0,0,'html',3,'marcel.sander@etribes.de'),(39,4,37,1,0,0,'TypeScript',3,'marcel.sander@etribes.de'),(40,4,21,1,0,0,'Java',4,'marcel.sander@etribes.de'),(41,4,38,1,0,0,'Python',4,'marcel.sander@etribes.de'),(42,4,50,1,0,0,'Go',4,'marcel.sander@etribes.de'),(43,4,43,2,0,0,'Shopware 6',41,'marcel.sander@etribes.de'),(44,4,44,3,0,0,'Spryker',41,'marcel.sander@etribes.de'),(45,4,45,3,0,0,'Commercetools',41,'marcel.sander@etribes.de'),(46,4,22,1,0,0,'OOP',6,'marcel.sander@etribes.de'),(47,4,23,1,0,0,'Funktional',6,'marcel.sander@etribes.de'),(48,4,24,1,0,0,'Clean Code',6,'marcel.sander@etribes.de'),(49,4,25,1,0,0,'Design Patterns',6,'marcel.sander@etribes.de'),(50,4,26,1,0,0,'UML',6,'marcel.sander@etribes.de'),(51,4,52,2,0,0,'MySQL / Maria / Percona',51,'marcel.sander@etribes.de'),(52,4,53,1,0,0,'Postgres',51,'marcel.sander@etribes.de'),(53,4,54,1,0,0,'MongoDB',51,'marcel.sander@etribes.de'),(54,4,55,1,0,0,'ElasticSearch',51,'marcel.sander@etribes.de'),(55,4,56,1,0,0,'Redis',51,'marcel.sander@etribes.de'),(56,7,3,3,1.5,3,'Frontend',1,'stefan.berkenhoff@etribes.de'),(57,7,14,2,0,0,'Javascript',3,'stefan.berkenhoff@etribes.de'),(58,7,39,3,0,0,'html',3,'stefan.berkenhoff@etribes.de'),(59,7,37,0,0,0,'TypeScript',3,'stefan.berkenhoff@etribes.de'),(60,7,40,1,0,0,'css, scss, less',3,'stefan.berkenhoff@etribes.de'),(61,7,6,1,0.5,1,'Architect',1,'stefan.berkenhoff@etribes.de'),(62,7,26,1,0,0,'UML',6,'stefan.berkenhoff@etribes.de'),(63,7,23,0,0,0,'Funktional',6,'stefan.berkenhoff@etribes.de'),(64,10,15,5,0,0,'jQuery',14,'yubraj.ghimire@etribes.de'),(65,10,35,4,0,0,'Laravel',20,'yubraj.ghimire@etribes.de'),(66,10,37,3,0,0,'TypeScript',3,'yubraj.ghimire@etribes.de'),(67,10,39,6,0,0,'html',3,'yubraj.ghimire@etribes.de'),(68,10,40,5,0,0,'css, scss, less',3,'yubraj.ghimire@etribes.de'),(69,10,36,3,0,0,'Symphony',20,'yubraj.ghimire@etribes.de'),(70,10,27,3,0,0,'bash',5,'yubraj.ghimire@etribes.de'),(71,10,28,3,0,0,'Git',5,'yubraj.ghimire@etribes.de'),(72,10,29,3,0,0,'CI/CD',5,'yubraj.ghimire@etribes.de'),(73,10,32,4,0,0,'Vagrant',5,'yubraj.ghimire@etribes.de'),(74,10,30,3,0,0,'Cloud (AWS, Azure etc.)',5,'yubraj.ghimire@etribes.de'),(75,10,31,3,0,0,'Docker',5,'yubraj.ghimire@etribes.de'),(76,10,52,5,0,0,'MySQL / Maria / Percona',51,'yubraj.ghimire@etribes.de'),(77,10,47,3,0,0,'Unit/Int/Func Tests',46,'yubraj.ghimire@etribes.de'),(78,10,22,4,0,0,'OOP',6,'yubraj.ghimire@etribes.de'),(79,10,44,4,0,0,'Spryker',41,'yubraj.ghimire@etribes.de'),(80,10,38,1,0,0,'Python',4,'yubraj.ghimire@etribes.de'),(81,13,35,2,0,0,'Laravel',20,'yannik.schwieger@etribes.de'),(82,13,20,6,3,4,'PHP',4,'yannik.schwieger@etribes.de'),(83,13,4,6,4.3333,6,'Backend',1,'yannik.schwieger@etribes.de'),(84,13,36,4,0,0,'Symphony',20,'yannik.schwieger@etribes.de'),(85,13,34,0,0,0,'Spring',21,'yannik.schwieger@etribes.de'),(86,13,38,4,0,0,'Python',4,'yannik.schwieger@etribes.de'),(87,13,50,3,0,0,'Go',4,'yannik.schwieger@etribes.de'),(88,13,3,4,5.25,6,'Frontend',1,'yannik.schwieger@etribes.de'),(89,13,15,5,0,0,'jQuery',14,'yannik.schwieger@etribes.de'),(90,13,16,5,0,0,'VueJs',14,'yannik.schwieger@etribes.de'),(91,13,17,3,0,0,'ReactJs',14,'yannik.schwieger@etribes.de'),(92,13,18,0,0,0,'Backbone JS',14,'yannik.schwieger@etribes.de'),(93,13,19,3,0,0,'Webpack',14,'yannik.schwieger@etribes.de'),(94,13,37,5,0,0,'TypeScript',3,'yannik.schwieger@etribes.de'),(95,13,14,6,3.2,5,'Javascript',3,'yannik.schwieger@etribes.de'),(96,13,39,5,0,0,'html',3,'yannik.schwieger@etribes.de'),(97,13,40,5,0,0,'css, scss, less',3,'yannik.schwieger@etribes.de'),(98,13,27,6,0,0,'bash',5,'yannik.schwieger@etribes.de'),(99,13,28,6,0,0,'Git',5,'yannik.schwieger@etribes.de'),(100,13,5,5,3.7143,6,'DevOps',1,'yannik.schwieger@etribes.de'),(101,13,29,5,0,0,'CI/CD',5,'yannik.schwieger@etribes.de'),(102,13,30,1,0,0,'Cloud (AWS, Azure etc.)',5,'yannik.schwieger@etribes.de'),(103,13,31,5,0,0,'Docker',5,'yannik.schwieger@etribes.de'),(104,13,32,0,0,0,'Vagrant',5,'yannik.schwieger@etribes.de'),(105,13,33,3,0,0,'Infrastruktur Design',5,'yannik.schwieger@etribes.de'),(106,13,22,6,0,0,'OOP',6,'yannik.schwieger@etribes.de'),(107,13,23,6,0,0,'Funktional',6,'yannik.schwieger@etribes.de'),(108,13,24,6,0,0,'Clean Code',6,'yannik.schwieger@etribes.de'),(109,13,25,5,0,0,'Design Patterns',6,'yannik.schwieger@etribes.de'),(110,13,26,5,0,0,'UML',6,'yannik.schwieger@etribes.de'),(111,13,6,5,5.6,6,'Architect',1,'yannik.schwieger@etribes.de'),(112,13,43,5,0,0,'Shopware 6',41,'yannik.schwieger@etribes.de'),(113,13,42,6,0,0,'Shopware 5',41,'yannik.schwieger@etribes.de'),(114,13,44,4,0,0,'Spryker',41,'yannik.schwieger@etribes.de'),(115,13,45,0,0,0,'Commercetools',41,'yannik.schwieger@etribes.de'),(116,13,41,4,3.75,6,'Softwareproducts',1,'yannik.schwieger@etribes.de'),(117,13,47,5,0,0,'Unit/Int/Func Tests',46,'yannik.schwieger@etribes.de'),(118,13,48,4,0,0,'Manual Testing',46,'yannik.schwieger@etribes.de'),(119,13,49,3,0,0,'E2E Tests',46,'yannik.schwieger@etribes.de'),(120,13,46,4,4,5,'Testing',1,'yannik.schwieger@etribes.de'),(121,13,52,5,0,0,'MySQL / Maria / Percona',51,'yannik.schwieger@etribes.de'),(122,13,53,4,0,0,'Postgres',51,'yannik.schwieger@etribes.de'),(123,13,54,5,0,0,'MongoDB',51,'yannik.schwieger@etribes.de'),(124,13,55,4,0,0,'ElasticSearch',51,'yannik.schwieger@etribes.de'),(125,13,56,5,0,0,'Redis',51,'yannik.schwieger@etribes.de'),(126,13,51,5,4.6,5,'Databases',1,'yannik.schwieger@etribes.de'),(127,13,1,4,4.7143,6,'Tech',0,'yannik.schwieger@etribes.de');
/*!40000 ALTER TABLE `user_result_index` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-25 19:31:36
