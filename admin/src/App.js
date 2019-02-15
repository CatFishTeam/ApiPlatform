import React from 'react';
import { HydraAdmin } from '@api-platform/admin';
import authProvider from './authProvider';
import Admin from './Admin'

const App = () => (
  <Admin authProvider={authProvider}>
  ...
  </Admin>
);

//export default () => App();
export default () => <HydraAdmin entrypoint={process.env.REACT_APP_API_ENTRYPOINT}/>;
