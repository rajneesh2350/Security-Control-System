# Security-Control-System
Security Control System made for observation/handling of Security Equipment like camras,login devices etc..

Features Implemented:
Room Selection - Fetches all rooms from your existing igpess_network table with floor filtering
Camera Integration - Opens mobile camera for photos/videos
Geo-Tagging - Automatically captures location coordinates and address
Image Compression - Compresses images to max 1200px with 75% quality, reducing storage space
Progress Bar - Shows upload progress and compression info
Daily Reports - View all media by date with compression stats
Equipment Checklist - Track status of networking, interactive board, WiFi, CCTV, UPS, Audio/Video
Responsive Design - Works on all devices (mobile, tablet, desktop)
Database Tables Created:
daily_room_reports - Stores all uploaded media with geo-tags and compression info
daily_room_checklist - Stores daily equipment status for each room
