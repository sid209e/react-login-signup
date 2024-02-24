import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom'; 

const ChangePassword = () => {
  const [passwords, setPasswords] = useState({
    currentPassword: '',
    newPassword: '',
    confirmPassword: '',
  });
  const navigate = useNavigate();

  const handleChange = (e) => {
    const { name, value } = e.target;
    setPasswords(prevData => ({ ...prevData, [name]: value }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    if (passwords.newPassword !== passwords.confirmPassword) {
      alert("New passwords do not match.");
      return;
    }
    const endpoint = 'http://localhost:8888/php/changepassword.php';
    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          currentPassword: passwords.currentPassword,
          newPassword: passwords.newPassword,
        }),
      });

      const data = await response.json();
      if (data.success) {
        alert('Password changed successfully.');
        navigate('/profile'); 
      } else {
        alert(data.message || 'Failed to change password.');
      }
    } catch (error) {
      console.error('Error changing password:', error);
      alert('An error occurred while changing your password. Please try again.');
    }
  };

  return (
    <div className="container">
      <h1>Change Password</h1>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="currentPassword">Current Password</label>
          <input type="password" className="form-control" id="currentPassword" name="currentPassword" value={passwords.currentPassword} onChange={handleChange} required />
        </div>
        <div className="form-group">
          <label htmlFor="newPassword">New Password</label>
          <input type="password" className="form-control" id="newPassword" name="newPassword" value={passwords.newPassword} onChange={handleChange} required />
        </div>
        <div className="form-group">
          <label htmlFor="confirmPassword">Confirm New Password</label>
          <input type="password" className="form-control" id="confirmPassword" name="confirmPassword" value={passwords.confirmPassword} onChange={handleChange} required />
        </div>
        <button type="submit" className="btn btn-primary">Change Password</button>
      </form>
    </div>
  );
};

export default ChangePassword;
