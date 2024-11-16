  <!-- Tags Modal -->
  <div class="modal fade" id="tagsModal" tabindex="-1" aria-labelledby="tagsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="tagsModalLabel">
                      <i class="bi bi-tags-fill me-2"></i>Tags
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Year Levels -->
                  <div class="filter-section">
                      <h6 class="filter-title">
                          <i class="bi bi-mortarboard me-2"></i>Year Levels
                      </h6>
                      <div class="filter-options">
                          <label class="filter-chip">
                              <input type="checkbox" name="year_level[]" value="1st Year">
                              <span>1st Year</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="year_level[]" value="2nd Year">
                              <span>2nd Year</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="year_level[]" value="3rd Year">
                              <span>3rd Year</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="year_level[]" value="4th Year">
                              <span>4th Year</span>
                          </label>
                      </div>
                  </div>

                  <!-- Departments -->
                  <div class="filter-section">
                      <h6 class="filter-title">
                          <i class="bi bi-building me-2"></i>Departments
                      </h6>
                      <div class="filter-options">
                          <label class="filter-chip">
                              <input type="checkbox" name="department[]" value="CICS">
                              <span>CICS</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="department[]" value="CABE">
                              <span>CABE</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="department[]" value="CAS">
                              <span>CAS</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="department[]" value="CIT">
                              <span>CIT</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="department[]" value="CTE">
                              <span>CTE</span>
                          </label>
                          <label class="filter-chip">
                              <input type="checkbox" name="department[]" value="CE">
                              <span>CE</span>
                          </label>
                      </div>
                  </div>

                  <!-- Courses -->
                  <div class="filter-section">
                      <h6 class="filter-title">
                          <i class="bi bi-book me-2"></i>Courses
                      </h6>
                      <div class="filter-options">
                          <label class="filter-chip" title="Bachelor of Science in Business Accounting">
                              <input type="checkbox" name="course[]" value="BSBA">
                              <span>BSBA</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Science in Management Accounting">
                              <input type="checkbox" name="course[]" value="BSMA">
                              <span>BSMA</span>
                          </label>
                          <!-- Add all other courses following the same pattern -->
                          <label class="filter-chip" title="Bachelor of Science in Psychology">
                              <input type="checkbox" name="course[]" value="BSP">
                              <span>BSP</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Arts in Communication">
                              <input type="checkbox" name="course[]" value="BAC">
                              <span>BAC</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Science in Industrial Engineering">
                              <input type="checkbox" name="course[]" value="BSIE">
                              <span>BSIE</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Industrial Technology - Computer Technology">
                              <input type="checkbox" name="course[]" value="BSIT-CE">
                              <span>BSIT-CE</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Industrial Technology - Electrical Technology">
                              <input type="checkbox" name="course[]" value="BSIT-Electrical">
                              <span>BSIT-E</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Industrial Technology - Electronics Technology">
                              <input type="checkbox" name="course[]" value="BSIT-Electronic">
                              <span>BSIT-ET</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Industrial Technology - ICT">
                              <input type="checkbox" name="course[]" value="BSIT-ICT">
                              <span>BSIT-ICT</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Science in Information Technology">
                              <input type="checkbox" name="course[]" value="BSIT">
                              <span>BSIT</span>
                          </label>
                          <label class="filter-chip" title="Bachelor of Secondary Education">
                              <input type="checkbox" name="course[]" value="BSE">
                              <span>BSE</span>
                          </label>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>


  <!-- Add Student Modal -->

  <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="studentModalLabel">
                      <i class="bi bi-person-plus-fill me-2"></i>Add New Student
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body p-4">
                  <form id="addStudentForm" method="POST" action="" enctype="multipart/form-data">
                      <!-- Name Section -->
                      <div class="row mb-3">
                          <div class="col-md-6">
                              <div class="form-floating">
                                  <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>
                                  <label for="firstName">First Name</label>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-floating">
                                  <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required>
                                  <label for="lastName">Last Name</label>
                              </div>
                          </div>
                      </div>

                      <!-- Contact Information -->
                      <div class="form-floating mb-3">
                          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                          <label for="email">Email Address</label>
                      </div>

                      <div class="mb-3">
                          <label class="form-label">Contact Number</label>
                          <div class="input-group">
                              <span class="input-group-text">+63</span>
                              <input type="text" class="form-control" id="contactNumber" name="contactNumber"
                                  placeholder="9XX XXX XXXX" maxlength="10" required>
                          </div>
                          <div id="errorMsg" class="invalid-feedback" style="display: none;">
                              Please enter a valid phone number
                          </div>
                          <small class="text-muted">Format: 9XX XXX XXXX</small>
                      </div>

                      <!-- Academic Information -->
                      <div class="row mb-3">
                          <div class="col-md-4">
                              <div class="form-floating">
                                  <select id="yearLevel" name="yearLevel" class="form-select">
                                      <option value="1st Year">1st Year</option>
                                      <option value="2nd Year">2nd Year</option>
                                      <option value="3rd Year">3rd Year</option>
                                      <option value="4th Year">4th Year</option>
                                  </select>
                                  <label for="yearLevel">Year Level</label>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="form-floating">
                                  <select id="department" name="department" class="form-select">
                                      <option value="CICS">CICS</option>
                                      <option value="CABE">CABE</option>
                                      <option value="CAS">CAS</option>
                                      <option value="CE">CE</option>
                                      <option value="CIT">CIT</option>
                                      <option value="CTE">CTE</option>
                                  </select>
                                  <label for="department">Department</label>
                              </div>
                          </div>
                      </div>

                      <div class="form-floating mb-3">
                          <select id="course" name="course" class="form-select">
                              <option value="BSBA">Bachelor of Science in Business Administration</option>
                              <option value="BSMA">Bachelor of Science in Management Accounting</option>
                              <option value="BSP">Bachelor of Science in Psychology</option>
                              <option value="BAC">Bachelor of Arts in Communication</option>
                              <option value="BSIE">Bachelor of Science in Industrial Engineering</option>
                              <option value="BSIT-CE">Bachelor of Industrial Technology - Computer Technology</option>
                              <option value="BSIT-Electrical">Bachelor of Industrial Technology - Electrical Technology</option>
                              <option value="BSIT-Electronic">Bachelor of Industrial Technology - Electronics Technology</option>
                              <option value="BSIT-ICT">Bachelor of Industrial Technology - ICT</option>
                              <option value="BSIT">Bachelor of Science in Information Technology</option>
                              <option value="BSE">Bachelor of Secondary Education</option>
                          </select>
                          <label for="course">Course</label>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                      <i class="bi bi-x-circle me-2"></i>Cancel
                  </button>
                  <button type="submit" class="btn btn-primary" form="addStudentForm">
                      <i class="bi bi-save me-2"></i>Save Student
                  </button>
              </div>
          </div>
      </div>
  </div>

  <!-- Edit Student -->

  <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="editStudentModalLabel">
                      <i class="bi bi-pencil-square me-2"></i>Edit Student
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body p-4">
                  <form id="editStudentForm" method="POST" action="">
                      <input type="hidden" name="student_id" id="editStudentId">

                      <!-- Name Section -->
                      <div class="row mb-3">
                          <div class="col-md-6">
                              <div class="form-floating">
                                  <input type="text" class="form-control" id="editFirstName" name="firstName" placeholder="Enter first name" required>
                                  <label for="editFirstName">First Name</label>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-floating">
                                  <input type="text" class="form-control" id="editLastName" name="lastName" placeholder="Enter last name" required>
                                  <label for="editLastName">Last Name</label>
                              </div>
                          </div>
                      </div>

                      <!-- Contact Information -->
                      <div class="form-floating mb-3">
                          <input type="email" class="form-control" id="editEmail" name="email" placeholder="Enter email" required>
                          <label for="editEmail">Email Address</label>
                      </div>

                      <div class="mb-3">
                          <label class="form-label">Contact Number</label>
                          <div class="input-group">
                              <span class="input-group-text">+63</span>
                              <input type="text" class="form-control" id="editContactNumber" name="contactNumber"
                                  placeholder="9XX XXX XXXX" maxlength="10" required>
                          </div>
                          <div id="editErrorMsg" class="invalid-feedback" style="display: none;">
                              Please enter a valid phone number
                          </div>
                          <small class="text-muted">Format: 9XX XXX XXXX</small>
                      </div>

                      <!-- Academic Information -->
                      <div class="row mb-3">
                          <div class="col-md-4">
                              <div class="form-floating">
                                  <select id="editYearLevel" name="yearLevel" class="form-select">
                                      <option value="1st Year">1st Year</option>
                                      <option value="2nd Year">2nd Year</option>
                                      <option value="3rd Year">3rd Year</option>
                                      <option value="4th Year">4th Year</option>
                                  </select>
                                  <label for="editYearLevel">Year Level</label>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="form-floating">
                                  <select id="editDepartment" name="department" class="form-select">
                                      <option value="CICS">CICS</option>
                                      <option value="CABE">CABE</option>
                                      <option value="CAS">CAS</option>
                                      <option value="CE">CE</option>
                                      <option value="CIT">CIT</option>
                                      <option value="CTE">CTE</option>
                                  </select>
                                  <label for="editDepartment">Department</label>
                              </div>
                          </div>
                      </div>

                      <div class="form-floating mb-3">
                          <select id="editCourse" name="course" class="form-select">
                              <option value="BSBA">Bachelor of Science in Business Administration</option>
                              <option value="BSMA">Bachelor of Science in Management Accounting</option>
                              <option value="BSP">Bachelor of Science in Psychology</option>
                              <option value="BAC">Bachelor of Arts in Communication</option>
                              <option value="BSIE">Bachelor of Science in Industrial Engineering</option>
                              <option value="BSIT-CE">Bachelor of Industrial Technology - Computer Technology</option>
                              <option value="BSIT-Electrical">Bachelor of Industrial Technology - Electrical Technology</option>
                              <option value="BSIT-Electronic">Bachelor of Industrial Technology - Electronics Technology</option>
                              <option value="BSIT-ICT">Bachelor of Industrial Technology - ICT</option>
                              <option value="BSIT">Bachelor of Science in Information Technology</option>
                              <option value="BSE">Bachelor of Secondary Education</option>
                          </select>
                          <label for="editCourse">Course</label>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                      <i class="bi bi-x-circle me-2"></i>Cancel
                  </button>
                  <button type="submit" class="btn btn-primary" form="editStudentForm">
                      <i class="bi bi-save me-2"></i>Update Student
                  </button>
              </div>
          </div>
      </div>
  </div>