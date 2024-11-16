BEGIN;

-- Table: course
CREATE TABLE IF NOT EXISTS public.course
(
    course_id serial NOT NULL,
    course_name character varying(100) NOT NULL UNIQUE, -- Ensures no duplicate course names
    CONSTRAINT course_pkey PRIMARY KEY (course_id)
);

-- Table: department
CREATE TABLE IF NOT EXISTS public.department
(
    department_id serial NOT NULL,
    department_name character varying(100) NOT NULL UNIQUE, -- Ensures no duplicate department names
    CONSTRAINT department_pkey PRIMARY KEY (department_id)
);

-- Table: year_level
CREATE TABLE IF NOT EXISTS public.year_level
(
    year_level_id serial NOT NULL,
    year_level character varying(50) NOT NULL UNIQUE, -- Ensure no duplicate year levels
    CONSTRAINT year_level_pkey PRIMARY KEY (year_level_id)
);

-- Table: admin
CREATE TABLE IF NOT EXISTS public.admin
(
    admin_id serial NOT NULL,
    first_name character varying(100) NOT NULL,
    last_name character varying(100) NOT NULL,
    email character varying(100) NOT NULL UNIQUE, -- Ensuring unique emails
    password character varying(100) NOT NULL,
    contact_number character varying(15) UNIQUE, -- Contact numbers should be unique
    department_id integer,
    otp character varying(6),
    otp_expiry timestamp without time zone,
    CONSTRAINT admin_pkey PRIMARY KEY (admin_id),
    CONSTRAINT valid_contact_number CHECK (length(contact_number) >= 7) -- Ensures valid contact number length
);

-- Table: announcement
CREATE TABLE IF NOT EXISTS public.announcement
(
    announcement_id serial NOT NULL,
    title character varying(255) NOT NULL,
    description TEXT NOT NULL,
    message character varying(255),
    admin_id integer NOT NULL, -- Admin must be associated
    image text,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT announcement_pkey PRIMARY KEY (announcement_id),
    CONSTRAINT announcement_staff_id_fkey FOREIGN KEY (admin_id)
        REFERENCES public.admin (admin_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE -- Ensures if admin is deleted, their announcements are deleted
);

-- Table: student
CREATE TABLE IF NOT EXISTS public.student
(
    student_id serial NOT NULL,
    email character varying(100) NOT NULL UNIQUE, -- Ensures unique emails
    password character varying(100) NOT NULL,
    first_name character varying(100) NOT NULL,
    last_name character varying(100) NOT NULL,
    contact_number character varying(15) UNIQUE, -- Contact numbers should be unique
    year_level_id integer NOT NULL,
    department_id integer NOT NULL,
    course_id integer NOT NULL,
    otp character varying(6),
    otp_expiry timestamp without time zone,
    CONSTRAINT student_pkey PRIMARY KEY (student_id),
    CONSTRAINT student_course_id_fkey FOREIGN KEY (course_id)
        REFERENCES public.course (course_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE, -- Ensure students are deleted if their course is deleted
    CONSTRAINT student_department_id_fkey FOREIGN KEY (department_id)
        REFERENCES public.department (department_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE, -- Ensure students are deleted if their department is deleted
    CONSTRAINT student_year_level_id_fkey FOREIGN KEY (year_level_id)
        REFERENCES public.year_level (year_level_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE, -- Ensure students are deleted if their year level is deleted
    CONSTRAINT valid_student_contact_number CHECK (length(contact_number) >= 7) -- Ensures valid contact number length
);

-- Junction table: announcement_department
CREATE TABLE IF NOT EXISTS public.announcement_department
(
    announcement_id integer NOT NULL,
    department_id integer NOT NULL,
    CONSTRAINT announcement_department_pkey PRIMARY KEY (announcement_id, department_id),
    CONSTRAINT announcement_department_announcement_id_fkey FOREIGN KEY (announcement_id)
        REFERENCES public.announcement (announcement_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE, -- Cascades deletions if announcement is deleted
    CONSTRAINT announcement_department_department_id_fkey FOREIGN KEY (department_id)
        REFERENCES public.department (department_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE -- Cascades deletions if department is deleted
);

-- Junction table: announcement_year_level
CREATE TABLE IF NOT EXISTS public.announcement_year_level
(
    announcement_id integer NOT NULL,
    year_level_id integer NOT NULL,
    CONSTRAINT announcement_year_level_pkey PRIMARY KEY (announcement_id, year_level_id),
    CONSTRAINT announcement_year_level_announcement_id_fkey FOREIGN KEY (announcement_id)
        REFERENCES public.announcement (announcement_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE, -- Cascades deletions if announcement is deleted
    CONSTRAINT announcement_year_level_year_level_id_fkey FOREIGN KEY (year_level_id)
        REFERENCES public.year_level (year_level_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE -- Cascades deletions if year level is deleted
);

-- Junction table: announcement_course
CREATE TABLE IF NOT EXISTS public.announcement_course
(
    announcement_id integer NOT NULL,
    course_id integer NOT NULL,
    CONSTRAINT announcement_course_pkey PRIMARY KEY (announcement_id, course_id),
    CONSTRAINT announcement_course_announcement_id_fkey FOREIGN KEY (announcement_id)
        REFERENCES public.announcement (announcement_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE, -- Cascades deletions if announcement is deleted
    CONSTRAINT announcement_course_course_id_fkey FOREIGN KEY (course_id)
        REFERENCES public.course (course_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE -- Cascades deletions if course is deleted
);

-- Table: logs
CREATE TABLE IF NOT EXISTS public.logs
(
    log_id serial NOT NULL,
    user_id integer, -- Optional, to track which user performed the action
    user_type character varying(50) NOT NULL, -- Can store if it's a 'student', 'admin', etc.
    action character varying(50) NOT NULL, -- Stores the action type, e.g., 'INSERT', 'UPDATE', 'DELETE', 'LOGIN'
    affected_table character varying(100) NOT NULL, -- Table where the action occurred
    affected_record_id integer, -- Stores the ID of the affected record (optional, if applicable)
    description text, -- Stores more details of the event, such as specific changes
    timestamp timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL, -- Logs the time the action happened
    CONSTRAINT logs_pkey PRIMARY KEY (log_id)
);

-- Optional foreign key to link logs to admins, assuming admin actions need to be logged
ALTER TABLE IF EXISTS public.logs
    ADD CONSTRAINT logs_admin_id_fkey FOREIGN KEY (user_id)
    REFERENCES public.admin (admin_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE SET NULL; -- If the admin is deleted, the log entry will not be removed

-- Optional foreign key to link logs to students, assuming student actions need to be logged
ALTER TABLE IF EXISTS public.logs
    ADD CONSTRAINT logs_student_id_fkey FOREIGN KEY (user_id)
    REFERENCES public.student (student_id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE SET NULL; -- If the student is deleted, the log entry will not be removed

CREATE TABLE IF NOT EXISTS public.sms_log (
    sms_log_id serial NOT NULL,
    announcement_id integer NOT NULL,
    student_id integer NOT NULL,
    status varchar(20) NOT NULL,
    sent_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT sms_log_pkey PRIMARY KEY (sms_log_id),
    CONSTRAINT sms_log_announcement_id_fkey FOREIGN KEY (announcement_id)
        REFERENCES public.announcement (announcement_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE,
    CONSTRAINT sms_log_student_id_fkey FOREIGN KEY (student_id)
        REFERENCES public.student (student_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
);

END;
