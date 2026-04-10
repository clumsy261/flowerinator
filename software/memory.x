*default*
0x10000 *(.flash.boot_config)

/*
 * Default linker section for more flash space (with WiFi/BT support).
 * This enables the ROM bootloader to apply the app-specific bootloader
 * and partition table as well as provide internal ROM API for WiFi/BT.
 */
IROM

/*
 * Force placing the .flash.boot_config in the boot image to enable
 * the ROM bootloader to detect the used configuration (qio/qout/dio/dout).
 * This is needed as the ROM bootloader does not use the flash boot
 * configuration from the efuse.
 */
.flash.boot_config :
{
    _ext_flash_boot_config = .;
    *(.flash.boot_config)
}
