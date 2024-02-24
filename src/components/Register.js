import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const Register = () => {
  const [userData, setUserData] = useState({
    username: '',
    email: '',
    password: '',
    age: '',
    dob: ''
  });
  const navigate = useNavigate(); 

  const handleChange = (e) => {
    const { name, value } = e.target;
    setUserData(prevState => ({
      ...prevState,
      [name]: value
    }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    const endpoint = 'http://localhost:8888/php/register.php';
    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData)
      });
  
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
  
      const data = await response.json();
      if (data.success) {
        alert('Registration successful!');
        navigate('/profile');
      } else {
        alert(data.message || 'Registration failed. Please try again.');
      }
    } catch (error) {
      console.error('Registration request failed:', error);
      alert('An error occurred. Please try again later.');
    }
  };
  

  return (
    <div className="container py-5">
      <div className="row">
        <div className="col-md-8 offset-md-2">
          <div className="card shadow-lg">
            <div className="card-header bg-primary text-white">
              <h3 className="text-center">Create Your Account</h3>
            </div>
            <div className="card-body p-5">
              <form id="registrationForm" onSubmit={handleSubmit}>
                <div className="form-group">
                  <label htmlFor="username">Username</label>
                  <input type="text" className="form-control" id="username" name="username" placeholder="Enter username" required value={userData.username} onChange={handleChange} />
                </div>
                <div className="form-group">
                  <label htmlFor="email">Email Address</label>
                  <input type="email" className="form-control" id="email" name="email" placeholder="Enter email" required value={userData.email} onChange={handleChange} />
                </div>
                <div className="form-group">
                  <label htmlFor="password">Password</label>
                  <input type="password" className="form-control" id="password" name="password" placeholder="Enter password" required value={userData.password} onChange={handleChange} />
                </div>
                <div className="form-group">
                  <label htmlFor="age">Age</label>
                  <input type="number" className="form-control" id="age" name="age" placeholder="Enter your age" required value={userData.age} onChange={handleChange} />
                </div>
                <div className="form-group">
                  <label htmlFor="dob">Date of Birth</label>
                  <input type="date" className="form-control" id="dob" name="dob" required value={userData.dob} onChange={handleChange} />
                </div>
                <button type="submit" className="btn btn-primary btn-block">Register</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Register;
