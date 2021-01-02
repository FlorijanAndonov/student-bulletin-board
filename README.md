# student-bulletin-board

Student bulletin board to display if a particular student has passed a particular board.

Each student has id / name / list of grades and belongs to a Board. 

The boards have their own parametars of which the output depends. 

localhost/student_board/?student={student_id} will output json/xml depending on the Board setting, and it will evaluate the passing flag of the student based on Board settings
