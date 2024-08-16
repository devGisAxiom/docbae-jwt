GetAvailableDoctors
InvitationDetails
GetAppointmentList
SearchDoctor
GetAllDoctors

http://3.110.159.138/docbae/public/api/getAvailableDoctors
http://3.110.159.138/docbae/public/api/invitationDetails?invitation_id=2
http://3.110.159.138/docbae/public/api/getAppointmentList
http://3.110.159.138/docbae/public/api/getAllDoctors
http://3.110.159.138/docbae/public/api/searchDoctor


CREATE INDEX - CREATE INDEX status on invitations(status)


EXPLAIN STATEMENT

GetAvailableDoctors - EXPLAIN SELECT * FROM doctors WHERE status = 1 AND is_verified = 1 AND emergency = 1;

InvitationDetails - EXPLAIN SELECT * FROM invitations WHERE id = 1;

GetAppointmentList - EXPLAIN SELECT * FROM invitations WHERE meeting_date = 2024-08-08 AND doctor_id = 1 AND status = 0;

                    EXPLAIN SELECT * FROM invitations WHERE doctor_id = ? AND status = 0;


DOCTORS TABLE
1. SELECT * FROM doctors WHERE status = 1 AND is_verified = 1 AND emergency = 1;

doctor_schedules table
1. SELECT * FROM `doctor_schedules` WHERE available_time =0;
2. SELECT * FROM `doctor_schedules` WHERE duration = 10

patients table
1. SELECT * FROM `patients` WHERE user_type =1;

members table
1. SELECT * FROM `members` WHERE user_type =1;
2. SELECT * FROM `members` WHERE patient_id = 15;

invitation table

1. EXPLAIN SELECT * FROM invitations WHERE id = 1;
2. SELECT * FROM invitations WHERE patient_id = 14;
3. SELECT * FROM invitations WHERE doctor_id  = 16 AND status = 0;

