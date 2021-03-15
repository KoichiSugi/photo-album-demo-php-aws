# photo-album-demo-php-aws
Demo of a photo album website in PHP using AWS SDK 

# What the website does
The website has a photo searching feature that a user can search for photos based on some search criteria and it will return a list of matching photos along with their metadata such as photo title, description, date, and keywords).
Photos can be uploaded on the website hosted by AWS EC2 webserver and they are stored in the S3 bucket after setting metadata for each photo.


This project demonstrates the following knowledge and technologies;

- Use of AWS SDK for PHP
- How to create IAM roles to enable an EC2 instance to access S3.
- Demonstrate the programmatic control of cloud services using an SDK.
- How to create a custom AMI with User Data. 
- How to create a Launch Configuration based on your custom AMI.
- How to create an Autoscaling Group across two Availability Zones with policies for scaling up and down.
- How to create a Load Balancer to distribute service requests.
- How to create a cached distribution of your website using CloudFront. 


# S3 photo storage
The bucket is private so that the photos are not publicly accessible.
The photos are readable to only the CloudFront distribution.

# Photos caching with CloudFront
Photos in the S3 bucket arecached in a CloudFront distribution that is available across all AWS 
edge locations. Only this CloudFront distribution has read access to the photos stored in the S3 bucket.

# Database with RDS

Your RDS instance have the following configs:
- DB engine version: MySQL 5.6.39
- DB instance class: db.t2.micro
- Public accessibility: No
- Backup retention period: 0 days

Database in your RDS instance with a table called photos that stores meta-data about the 
photos stored in the S3 bucket:
- photo title
- description
- date of photo
- keywords 
- reference to the photo object in S3.

