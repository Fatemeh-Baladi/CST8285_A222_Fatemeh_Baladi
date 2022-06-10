
--
-- Database: `demo` and php web application user
CREATE DATABASE demo;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON demo.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE demo;
--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `text` varchar(100) NOT NULL,
  `date` varchar(255) NOT NULL,
  `image` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `number`, `text`, `date`, `image`) VALUES
(1, 1, 'Hello', '02.02.2009', 'C:\Users\balad\Desktop\level 2\1.jpg'),
(2, 2, 'Good', '01.01.2011' , 'C:\Users\balad\Desktop\level 2\1.jpg'),
(3, 3, 'Morning', '03.03.2003', 'C:\Users\balad\Desktop\level 2\1.jpg');

