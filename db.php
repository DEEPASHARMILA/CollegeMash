<?php
include 'incl/db.php';
/*****************************************************
register

email:		Email used to log in.
token:		The token used to verify the account.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS register(
	user_id		BIGINT UNSIGNED		NOT NULL AUTO_INCREMENT,
	email		VARCHAR(150)		NOT NULL DEFAULT "",
	token		VARCHAR(22)			NOT NULL,
	
	PRIMARY KEY (user_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "REGISTER TABLE CREATED!<br/>";

/*****************************************************
login

email:		Email used to log in.
password:	SHA512 hashed and salted.
failed:		How many times the user failed to login
			this session. Reset on successful login,
			requires captcha after 1 failed attempt.
is_active:	0 = Not Verified | 1 = Verified
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS login(
	user_id		BIGINT UNSIGNED		NOT NULL,
	email		VARCHAR(150)		NOT NULL DEFAULT "",
	password	VARCHAR(60)			NOT NULL DEFAULT "",
	failed		TINYINT				NOT NULL DEFAULT 0,
	is_active	TINYINT				NOT NULL DEFAULT 0,
	
	PRIMARY KEY (user_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "LOGIN TABLE CREATED!<br/>";

/*****************************************************
basicInfo

Contains basic information that will be displayed on
the users page.

profilepic:	userid.'_'.time().'_'.token().'.'.$ext
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS basicInfo(
	user_id			BIGINT UNSIGNED		NOT NULL,
	college_id		INT UNSIGNED		NOT NULL,
	major_id		BIGINT UNSIGNED		NOT NULL,
	fname			VARCHAR(50)			NOT NULL,
	lname			VARCHAR(100)		NOT NULL,
	dob				DATE				NOT NULL,
	relationship	TINYINT				NOT NULL DEFAULT 0,
	profilepic		VARCHAR(50)			NOT NULL DEFAULT "default.png",
	signup			DATE				NOT NULL,
	about			VARCHAR(1000)		NOT NULL DEFAULT "",
	gender			TINYINT				NOT NULL DEFAULT 0,
	
	PRIMARY KEY (user_id)	
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "BASICINFO TABLE CREATED!<br/>";

/*****************************************************
images

image_id:	Unique ID of the image. Also serves as the
			name of the image.
			userid.'_'.time().'_'.token().'.'.$ext
user_id:	Who owns the image.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS images(
	image_id	VARCHAR(100)		NOT NULL,
	user_id		BIGINT UNSIGNED	NOT NULL,
	
	PRIMARY KEY (image_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "IMAGES TABLE CREATED!<br/>";

/*****************************************************
photoAlbum

album_id:	Unique ID of the album.
			userid.'_'.time()
user_id:	Who owns the image.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS images(
	image_id	VARCHAR(50)			NOT NULL,
	user_id		BIGINT UNSIGNED	NOT NULL,
	
	PRIMARY KEY (image_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "IMAGES TABLE CREATED!<br/>";

/*****************************************************
college

name:		The name of the college.
email:		Domain of the student email address.
			NIU = students.niu.edu
picture:	Name of image for the college.
info:		Information about the college.
location:	Where the college is located.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS college(
	college_id	INT UNSIGNED		NOT NULL AUTO_INCREMENT,
	name		VARCHAR(150)		NOT NULL DEFAULT "",
	email		VARCHAR(50)			NOT NULL DEFAULT "",
	picture		VARCHAR(100)		NOT NULL DEFAULT "",
	info		VARCHAR(2000)		NOT NULL DEFAULT "",
	location	VARCHAR(200)		NOT NULL DEFAULT "",
	
	PRIMARY KEY (college_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));

$query = "INSERT INTO college (name, email)
		VALUES ('Northern Illinois University', 'students.niu.edu')";
mysql_query($query, $db) or die(mysql_error($db));
echo "COLLEGE TABLE CREATED!<br/>";

/*****************************************************
major

college_id:	What college does this major belong to?
major:		Name of the major.
			college_id.'_'.time()
avrv:		Abreviation of the major.
			Computer Science = CSCI
info:		Information about the major.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS major(
	major_id	VARCHAR(50)			NOT NULL,
	college_id	INT UNSIGNED		NOT NULL,
	major		VARCHAR(100)		NOT NULL,
	abrv		VARCHAR(5)			NOT NULL,
	info		VARCHAR(2500)		NOT NULL,
	
	PRIMARY KEY (major_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "MAJOR TABLE CREATED!<br/>";
/*****************************************************
pointAmount

Stores how many points certain actions are worth. Also
stores a description of how to get the points.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS pointAmount(
	point_id			INT UNSIGNED		NOT NULL AUTO_INCREMENT,
	point_name			VARCHAR(100)		NOT NULL,
	point_desc			VARCHAR(1000)		NOT NULL,
	point_amt			TINYINT				NOT NULL DEFAULT 1,
	
	PRIMARY KEY (point_id)	
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "POINTAMOUNT TABLE CREATED!<br/>";

/*****************************************************
userStats

points:		How many points the user has earned.
regDays:	How many days the user has been
			registered.
timeOnline:	How much time the user has spent
			online.
logins:		How many times the user has logged in.
status:		How many status' the user has posted.
posts:		How many posts the user has made on other
			user's walls.
comments:	How many comments the user has left.
questions:	How many questions the user has asked.
answers:	How many questions the user has answered.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS userStats(
	user_id			BIGINT UNSIGNED		NOT NULL,
	points			INT	UNSIGNED		NOT NULL DEFAULT 0,
	regDays			INT UNSIGNED		NOT NULL DEFAULT 0,
	timeOnline		INT UNSIGNED		NOT NULL DEFAULT 0,
	logins			INT UNSIGNED		NOT NULL DEFAULT 0,
	status			INT UNSIGNED		NOT NULL DEFAULT 0,
	posts			INT UNSIGNED		NOT NULL DEFAULT 0,
	comments		INT UNSIGNED		NOT NULL DEFAULT 0,
	questions		INT UNSIGNED		NOT NULL DEFAULT 0,
	answers			INT UNSIGNED		NOT NULL DEFAULT 0,
	
	PRIMARY KEY (user_id)	
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "USERSTATS TABLE CREATED!<br/>";

/*****************************************************
userRank

Stores ranks that are achieved based on point totals
as well as other factors that have not yet been realized.

rank_badge: Image name for the badge the
			user unlocks for the rank.
req_points: How many points a user needs.
req_regDays: How many days a user must be
			regsitered for the rank.
req_timeOnline: How many seconds the user
				needs to be online.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS userRank(
	rank_id			INT UNSIGNED		NOT NULL AUTO_INCREMENT,
	rank_name		VARCHAR(100)		NOT NULL,
	rank_badge		VARCHAR(100)		NOT NULL,
	req_points		INT UNSIGNED		NOT NULL,
	req_regDays		INT UNSIGNED		NOT NULL,
	req_timeOnline	INT UNSIGNED		NOT NULL,
	
	PRIMARY KEY (rank_id)	
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "USERRANK TABLE CREATED!<br/>";

/*****************************************************
award

awardName:	The name of the award.
awardImg:	The image name of the award.
points:		How many points the user needs.
regDays:	How many days the user must be registered.
timeOnline:	How much time the user must be online.
logins:		How many times the user needs to have logged
			logged in.
status:		How many status' the user needs to post.
posts:		How many posts the user needs to post on
			other's walls.
comments:	How many comments the user needs to leave.
questions:	How many questions the user needs to ask.
answers:	How many questions the user needs to answer.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS awards(
	award_id		INT UNSIGNED	NOT NULL AUTO_INCREMENT,
	awardName		VARCHAR(100)	NOT NULL,
	awardImg		VARCHAR(100)	NOT NULL,
	points			INT UNSIGNED	NOT NULL DEFAULT 0,
	regDays			INT UNSIGNED	NOT NULL DEFAULT 0,
	timeOnline		INT UNSIGNED	NOT NULL DEFAULT 0,
	logins			INT UNSIGNED	NOT NULL DEFAULT 0,
	status			INT UNSIGNED	NOT NULL DEFAULT 0,
	posts			INT UNSIGNED	NOT NULL DEFAULT 0,
	comments		INT UNSIGNED	NOT NULL DEFAULT 0,
	questions		INT UNSIGNED	NOT NULL DEFAULT 0,
	answers			INT UNSIGNED	NOT NULL DEFAULT 0,
	
	PRIMARY KEY (award_id)	
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "TROPHIES TABLE CREATED!<br/>";

/*****************************************************
message

message:	The contents of the message.
time:		When the message was sent.
status:		Has the message been read?
			0 = no | 1 = yes
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS message(
	message_id		VARCHAR(100)		NOT NULL,
	sender_id		BIGINT UNSIGNED		NOT NULL,
	recipient_id	BIGINT UNSIGNED		NOT NULL,
	message			VARCHAR(10000)		NOT NULL,
	time			TIMESTAMP			NOT NULL DEFAULT CURRENT_TIMESTAMP,
	status			TINYINT UNSIGNED	NOT NULL DEFAULT 0,
	
	PRIMARY KEY (message_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "MESSAGE TABLE CREATED!<br/>";

/*****************************************************
status

college_id:	Display status to all users in the college.
status:		The contents of the status, 420 characters
			maximum. ;)
time:		What time the status was posted.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS status(
	status_id	VARCHAR(100)		NOT NULL,
	user_id		BIGINT UNSIGNED		NOT NULL,
	college_id	INT UNSIGNED		NOT NULL,
	status		VARCHAR(420)		NOT NULL,
	time		TIMESTAMP			NOT NULL DEFAULT CURRENT_TIMESTAMP,
	
	
	
	PRIMARY KEY (status_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "STATUS TABLE CREATED!<br/>";

/*****************************************************
friendlist

fl_id:		The ID of the friend list.
			user_id.'_'.time()
user_id:	The ID of the user creating the list.
fl_name:	The name of the list.

*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS friendlist(
	fl_id		VARCHAR(50)		NOT NULL,
	user_id		BIGINT UNSIGNED	NOT NULL,
	fl_name		VARCHAR(100)	NOT NULL,
	
	PRIMARY KEY (fl_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "FRIENDLIST TABLE CREATED!<br/>";

/*****************************************************
friend

friend_id:	The ID of the friendship.
			user_id.'_'.friend_id
user_id:	The ID of the user.
friend:		The ID of the user's friend.
added:		When they became friends.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS friend(
	friend_id	VARCHAR(50)			NOT NULL,
	user_id		BIGINT UNSIGNED		NOT NULL,
	friend		BIGINT UNSIGNED		NOT NULL,
	added		TIMESTAMP			NOT NULL DEFAULT CURRENT_TIMESTAMP,
	
	PRIMARY KEY (friend_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "FRIEND TABLE CREATED!<br/>";

/*****************************************************
pendingFriend

friend_id:	The ID of the friendship.
			user_id.'_'.notify
user_id:	The ID of the user sending the request.
notify:		The ID of the user to be notified.
added:		When they became friends.
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS pendingFriend(
	friend_id	VARCHAR(50)			NOT NULL,
	user_id		BIGINT UNSIGNED		NOT NULL,
	notify		BIGINT UNSIGNED		NOT NULL,
	added		TIMESTAMP			NOT NULL DEFAULT CURRENT_TIMESTAMP,
	
	PRIMARY KEY (friend_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "PENDINGFRIEND TABLE CREATED!<br/>";

/*****************************************************
blocked

blocked_id:	The ID of the block.
			user_id.'_'.blocked
user_id:	The user doing the blocking.
blocked:	The user being blocked.
added:		When was this block put into place?
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS blocked(
	blocked_id	VARCHAR(50)			NOT NULL,
	user_id		BIGINT UNSIGNED		NOT NULL,
	blocked		BIGINT UNSIGNED		NOT NULL,
	added		TIMESTAMP			NOT NULL DEFAULT CURRENT_TIMESTAMP,
	
	PRIMARY KEY (blocked_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "BLOCKED TABLE CREATED!<br/>";
/*****************************************************
mute - stop a user from showing up in news feed.

mute_id:	The ID of the mute.
			user_id.'_'.mute_user
user_id:	The user doing the muting.
mute_user:	The user being muted.
added:		When was this mute put into place?
*****************************************************/
$query = 'CREATE TABLE IF NOT EXISTS mute(
	mute_id		VARCHAR(50)			NOT NULL,
	user_id		BIGINT UNSIGNED		NOT NULL,
	mute_user	BIGINT UNSIGNED		NOT NULL,
	added		TIMESTAMP			NOT NULL DEFAULT CURRENT_TIMESTAMP,
	
	PRIMARY KEY (mute_id)
)
ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));
echo "MUTE TABLE CREATED!<br/>";

echo "DATABASE CREATION COMPLETE!"
?>