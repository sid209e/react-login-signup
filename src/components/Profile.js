import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

const Profile = () => {
  const [profileData, setProfileData] = useState({
    username: '',
    email: '',
    age: '',
    dob: ''
  });

  const navigate = useNavigate();

  useEffect(() => {
    const fetchProfileData = async () => {
      const user = JSON.parse(localStorage.getItem('user')); 

      if (!user) {
        console.log('No user data found, redirecting to login...');
        navigate('/login');
        return;
      }
      
      setProfileData({
        username: user.username,
        email: user.email,
        age: user.age,
        dob: user.dob,
      });
    };

    fetchProfileData();
  }, [navigate]);

  return (
    <div className="container py-5">
      <div className="row">
        <div className="col-md-8 offset-md-2">
          <h2>Your Profile</h2>
          <p><strong>Username:</strong> {profileData.username}</p>
          <p><strong>Email:</strong> {profileData.email}</p>
          <p><strong>Age:</strong> {profileData.age}</p>
          <p><strong>Date of Birth:</strong> {profileData.dob}</p>
          <button className="btn btn-info" onClick={() => navigate('/update-profile')}>Update Details</button>
          <button className="btn btn-secondary" onClick={() => navigate('/change-password')}>Change Password</button>
        </div>
      </div>
    </div>
  );
};

export default Profile;
