// src/components/Home.js
import React from 'react';
import { Link } from 'react-router-dom';

const Home = () => {
  return (
    <div className="container py-5">
      <div className="row">
        <div className="col-md-8 offset-md-2 text-center">
          <h1>Welcome to Our Service</h1>
          <p className="lead mt-4">Join us and explore our services.</p>
          <div className="mt-5">
          <Link to="/register" className="btn btn-primary btn-lg mr-2">Register</Link>
          <Link to="/login" className="btn btn-success btn-lg">Login</Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Home;
