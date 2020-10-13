#!ipxe
:menustart
menu iPXE Boot Menu (master)
item --gap -- Windows
item --key w boot_sccm_auto (W)indows (YKF)
item --gap
item --gap --	Ubuntu
item --key b install_ubuntu_18.04 	Ubuntu 18.04 (B)ionic
item --key f install_ubuntu_20.04 	Ubuntu 20.04 (F)ocal
item --gap
item --gap -- Advanced
item --key a advanced (A)dvanced Options

choose os && goto ${os}

:advanced
menu advanced Menu
item --key s shell		Drop to iPxe (s)hell
item --key r reload (R)eload Menu
item --key d hostinfo 	Computer (D)etails
item boot_sccm_dfw SCCM (DFW)
item boot_sccm_lhr SCCM (LHR)
item boot_sccm_oak SCCM (OAK)
item boot_sccm_c291 SCCM (C29 1)
item boot_sccm_c292 SCCM (C29 2)
item boot_sccm_c293 SCCM (C29 3)
item install_ubuntu_16.04 	Ubuntu 16.04 Xenial
item menustart Go back

choose os && goto ${os}

:shell
echo Type exit to get the back to the menu
shell
goto menustart
:end

#
# Shell
#
:shell
shell

#
# reload
#
:reload
chain http://ipxe.home.net/boot/boot.php?MAC=${netX/mac}&IP=${ip}

#
# Ubuntu
#
:install_ubuntu_20.04
set initPath http://repo-mirror.corvette.home.net/ubuntu/dists/focal/main/installer-amd64/current/images/netboot/ubuntu-installer/amd64/
set preseedurl https://gitlab.home.net/it-desktop-technical-leads/ubuntu-administration/raw/master/seeds/focal.seed
kernel ${initPath}linux auto=true priority=critical preseed/url=${preseedurl} initrd=initrd.gz
initrd ${initPath}initrd.gz
boot

:install_ubuntu_18.04
set initPath http://repo-mirror.corvette.home.net/ubuntu/dists/bionic/main/installer-amd64/current/images/netboot/ubuntu-installer/amd64/
set preseedurl https://gitlab.home.net/it-desktop-technical-leads/ubuntu-administration/raw/master/seeds/bionic.seed
kernel ${initPath}linux auto=true priority=critical preseed/url=${preseedurl} debian-installer/allow_unauthenticated_ssl=true initrd=initrd.gz
initrd ${initPath}initrd.gz
boot

:install_ubuntu_16.04
set initPath http://repo-mirror.corvette.home.net/ubuntu/dists/xenial-updates/main/installer-amd64/current/images/hwe-netboot/ubuntu-installer/amd64/
set preseedurl http://dtadm001ykf.home.net/seed/dev_xenial.seed
kernel ${initPath}linux auto=true priority=critical preseed/url=${preseedurl} debian-installer/allow_unauthenticated_ssl=true initrd=initrd.gz
initrd ${initPath}initrd.gz
boot

#
# Windows
#
:boot_sccm_auto
echo Selected sitecode YKF ||
echo Booting to SCCM DP 1.1.1.1 ||
sleep 5

set netX/next-server 1.1.1.1
set next-server 1.1.1.1
imgexec tftp://${netX/next-server}/SMSBoot\x64\wdsmgfw.efi


:boot_sccm_dfw
set netX/next-server 10.150.24.204
set next-server 1.1.1.1
imgexec tftp://${netX/next-server}/SMSBoot\\x64\\wdsmgfw.efi

:boot_sccm_lhr
set netX/next-server 1.1.1.1
set next-server 1.1.1.1
imgexec tftp://${netX/next-server}/SMSBoot\\x64\\wdsmgfw.efi

:boot_sccm_c291
set netX/next-server 1.1.1.1
set next-server 1.1.1.1
imgexec tftp://${netX/next-server}/SMSBoot\\x64\\wdsmgfw.efi

:boot_sccm_c292
set netX/next-server 1.1.1.1
set next-server 1.1.1.1
imgexec tftp://${netX/next-server}/SMSBoot\\x64\\wdsmgfw.efi

:boot_sccm_c293
set netX/next-server 1.1.1.1
set next-server 1.1.1.1
imgexec tftp://${netX/next-server}/SMSBoot\\x64\\wdsmgfw.efi

:boot_sccm_oak
set netX/next-server 1.1.1.1
set next-server 1.1.1.1
imgexec tftp://${netX/next-server}/SMSBoot\\CNC002CF\\x64\\wdsmgfw.efi

:hostinfo
echo This computer.. ${hostname} ||
echo MAC address.... ${mac} ||
echo IP address..... ${ip} ||
echo Netmask........ ${netmask} ||
echo Domain......... ${domain} ||
echo Serial......... ${serial} ||
echo Asset number... ${asset} ||
echo Manufacturer... ${manufacturer} ||
echo Product........ ${product} ||
echo BIOS platform.. ${platform} ||
echo iPXE branch.. master ||
echo ||
echo press any key to return to Menu ||
prompt
goto menustart
