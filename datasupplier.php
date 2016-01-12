<?php 

// simulate that this proccess might take a while so you can see the loadingMessage option work.
sleep(1);

$typeID = $_GET['typeID'];
$courseID = $_GET['courseID'];
$html = $_GET['html'];

$types = array();
$types['DE'] = "Departments";
$types['GE'] = "General Education";
$types['CA'] = "Career";


$courses = array();
$courses['DE']['AAAS'] = 'African and African American Studies';
$courses['DE']['AFR-STUD'] = 'African Studies';
$courses['DE']['ANTHRO'] = 'Anthropology';
$courses['DE']['APP-COMP'] = 'Applied Computation';
$courses['DE']['APP-MATH'] = 'Applied Mathematics';
$courses['DE']['APP-PHYS'] = 'Applied Physics';
$courses['DE']['ARCH'] = 'Architecture, Landscape Architecture, and Urban Planning';
$courses['DE']['ASIAN-STUD'] = 'Asian Studies';
$courses['DE']['ASTRON'] = 'Astronomy';
$courses['DE']['BSDM'] = 'Biological Sciences in Dental Medicine';
$courses['DE']['BSPH'] = 'Biological Sciences in Public Health';
$courses['DE']['BIOPHYS'] = 'Biophysics';
$courses['DE']['BIOSTAT'] = 'Biostatistics';
$courses['DE']['BUSI-STUD'] = 'Business Studies';
$courses['DE']['CELTIC'] = 'Celtic Languages and Literatures';
$courses['DE']['CHEM'] = 'Chemistry';
$courses['DE']['CHEM-PHYSBIO'] = 'Chemical and Physical Biology';
$courses['DE']['CHEM-BIO'] = 'Chemical Biology';
$courses['DE']['CHEM-PHYS'] = 'Chemical Physics';
$courses['DE']['CHEM-CHEMBIO'] = 'Chemistry and Chemical Biology';
$courses['DE']['CLASSICS'] = 'Classics';
$courses['DE']['COMP-LIT'] = 'Comparative Literature';
$courses['DE']['CS'] = 'Computer Science';
$courses['DE']['DRAMA'] = 'Dramatic Arts';
$courses['DE']['EPS'] = 'Earth and Planetary Sciences';
$courses['DE']['EAS'] = 'East Asian Studies';
$courses['DE']['ECON'] = 'Economics';
$courses['DE']['ES'] = 'Engineering Sciences';
$courses['DE']['ENGLISH'] = 'English';
$courses['DE']['ESPP'] = 'Environmental Science and Public Policy';
$courses['DE']['ETH-STUD'] = 'Ethnic Studies';
$courses['DE']['EURO-STUD'] = 'European Studies';
$courses['DE']['EXPOS'] = 'Expository Writing';
$courses['DE']['FILM-VIS'] = 'Film and Visual Studies';
$courses['DE']['FOLK-MYTH'] = 'Folklore and Mythology';
$courses['DE']['GERMANIC'] = 'Germanic Languages and Literatures';
$courses['DE']['GHHP'] = 'Global Health and Health Policy';
$courses['DE']['GOV'] = 'Government';
$courses['DE']['HEALTH-POL'] = 'Health Policy';
$courses['DE']['HIST'] = 'History';
$courses['DE']['HIST-LIT'] = 'History and Literature';
$courses['DE']['HIST-AC'] = 'History of American Civilization';
$courses['DE']['HAA'] = 'History of Art and Architecture';
$courses['DE']['HIST-SCI'] = 'History of Science';
$courses['DE']['HEB'] = 'Human Evolutionary Biology';
$courses['DE']['IAAS'] = 'Inner Asian and Altaic Studies';
$courses['DE']['LAIS'] = 'Latin American and Iberian Studies';
$courses['DE']['LS'] = 'Life Sciences';
$courses['DE']['LING'] = 'Linguistics';
$courses['DE']['LIT'] = 'Literature';
$courses['DE']['MATH'] = 'Mathematics';
$courses['DE']['MEDIC-SCI'] = 'Medical Sciences';
$courses['DE']['MED-STUD'] = 'Medieval Studies';
$courses['DE']['MID-EAST'] = 'Middle Eastern Studies';
$courses['DE']['MBB'] = 'Mind, Brain, and Behavior';
$courses['DE']['MCB'] = 'Molecular and Cellular Biology';
$courses['DE']['MUSIC'] = 'Music';
$courses['DE']['NEAR-EAST'] = 'Near Eastern Languages and Civilizations';
$courses['DE']['NEUROBIO'] = 'Neurobiology';
$courses['DE']['OCEAN'] = 'Oceanography';
$courses['DE']['OEB'] = 'Organismic and Evolutionary Biology';
$courses['DE']['PHIL'] = 'Philosophy';
$courses['DE']['PHYS'] = 'Physics';
$courses['DE']['PS'] = 'Physical Sciences';
$courses['DE']['POL-ECON-GOV'] = 'Political Economy and Government';
$courses['DE']['PSYCH'] = 'Psychology';
$courses['DE']['PUB-POL'] = 'Public Policy';
$courses['DE']['STUD-REL'] = 'The Study of Religion';
$courses['DE']['ROMANC'] = 'Romance Languages and Literatures';
$courses['DE']['RUS-EEURO-CENASIA'] = 'Russia, Eastern Europe, and Central Asian Studies';
$courses['DE']['SANSKR'] = 'Sanskrit and Indian Studies';
$courses['DE']['SLAVIC'] = 'Slavic Languages and Literatures';
$courses['DE']['SOC-POL'] = 'Social Policy';
$courses['DE']['SOC-STUD'] = 'Social Studies';
$courses['DE']['SOCIOL'] = 'Sociology';
$courses['DE']['SAS'] = 'South Asian Studies';
$courses['DE']['STAT'] = 'Statistics';
$courses['DE']['SCRB'] = 'Stem Cell and Regenerative Biology';
$courses['DE']['SYS-BIO'] = 'Systems Biology';
$courses['DE']['UKRAINE'] = 'Ukrainian Studies';
$courses['DE']['VES'] = 'Visual and Environmental Studies';
$courses['DE']['WGS'] = 'Women, Gender, and Sexuality';


$courses['GE']['AESTH&INTP'] = 'Aesthetic and Interpretive Understanding';
$courses['GE']['CULTR&BLF'] = 'Culture and Belief';
$courses['GE']['E&M-REASON'] = 'Empirical and Mathematical Reasoning';
$courses['GE']['ETH-REASON'] = 'Ethical Reasoning';
$courses['GE']['SCI-LIVSYS'] = 'Science of Living Systems';
$courses['GE']['SCI-PHYSYS'] = 'Science of Physical Universe';
$courses['GE']['SOC-WORLD'] = 'Societies of the World';
$courses['GE']['US-WORLD'] = 'United States in the World';


$courses['CA']['CONSULT'] = 'Consulting';
$courses['CA']['CORPORATE'] = 'Corporate';
$courses['CA']['FINANCE'] = 'Finance';
$courses['CA']['INTERVIEW'] = 'Interview (General)';
$courses['CA']['MEDICINE'] = 'Medicine';
$courses['CA']['TECH'] = 'Tech';



if($typeID && !$courseID){
	echo json_encode( $courses[$typeID] );
} else {
	echo '{}';
}

?>


