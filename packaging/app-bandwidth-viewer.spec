
Name: app-bandwidth-viewer
Epoch: 1
Version: 2.3.0
Release: 1%{dist}
Summary: Bandwidth Viewer
License: GPLv3
Group: ClearOS/Apps
Packager: Tim Burgess
Vendor: Tim Burgess
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
The Bandwidth Viewer draws a live graph of your interface bandwidth. This helps to determine the current speed of your interfaces and identify bandwidth problems across the network.

%package core
Summary: Bandwidth Viewer - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-base-core >= 1:1.4.22

%description core
The Bandwidth Viewer draws a live graph of your interface bandwidth. This helps to determine the current speed of your interfaces and identify bandwidth problems across the network.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/bandwidth_viewer
cp -r * %{buildroot}/usr/clearos/apps/bandwidth_viewer/


%post
logger -p local6.notice -t installer 'app-bandwidth-viewer - installing'

%post core
logger -p local6.notice -t installer 'app-bandwidth-viewer-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/bandwidth_viewer/deploy/install ] && /usr/clearos/apps/bandwidth_viewer/deploy/install
fi

[ -x /usr/clearos/apps/bandwidth_viewer/deploy/upgrade ] && /usr/clearos/apps/bandwidth_viewer/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-bandwidth-viewer - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-bandwidth-viewer-core - uninstalling'
    [ -x /usr/clearos/apps/bandwidth_viewer/deploy/uninstall ] && /usr/clearos/apps/bandwidth_viewer/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/bandwidth_viewer/controllers
/usr/clearos/apps/bandwidth_viewer/htdocs
/usr/clearos/apps/bandwidth_viewer/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/bandwidth_viewer/packaging
%dir /usr/clearos/apps/bandwidth_viewer
/usr/clearos/apps/bandwidth_viewer/deploy
/usr/clearos/apps/bandwidth_viewer/language
